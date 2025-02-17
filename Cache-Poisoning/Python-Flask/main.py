from flask import Flask, redirect,g , url_for, Blueprint, request,Response, render_template
from flask_caching import Cache
import uuid
import mariadb
import datetime

app=Flask(__name__)

app.config["CACHE_TYPE"] = "RedisCache"
app.config["CACHE_REDIS_HOST"] = "localhost"
app.config["CACHE_DEFAULT_TIMEOUT"] = 604800
cache = Cache(app)

def connectionDB():
	try:
		conn = mariadb.connect(
			host="127.0.0.1",
			user="root",
			password="password",
			database="sqli",
		)

		return conn
	except mariadb.Error as e:
		return {"Error":str(e)}

def run_query(query, params=None):
	conn = connectionDB()
	if isinstance(conn, dict):
		return conn

	try:
		cursor = conn.cursor(dictionary=True)
		cursor.execute(query, params or ())
		conn.commit()
		result = {
			"success":True,
			"affected_rows":cursor.rowcount,
			"result":cursor.fetchall(),
		}

		return result
	except mariadb.Error as e:
		print("Error:",e,flush=True)
		return {"error":str(e)}
	finally:
		cursor.close()
		conn.close()

@app.route('/', methods=['GET','POST'])
def index():
	if "id" not in request.cookies:
		unique_id = str(uuid.uuid4())
		run_query("INSERT INTO uuids VALUES(%s, %s);",(unique_id,0))
	else:
		unique_id = request.cookies.get("id")
		res = run_query("SELECT * FROM uuids WHERE id=%s;",(unique_id,))
		if "affected_rows" not in res:
			print("ERRROR:",res)
			return "ERRORRR"
		if res["affected_rows"] == 0:
			unique_id = str(uuid.uuid4())
			run_query("INSERT INTO uuids VALUES(%s, %s);",(unique_id,0))
	html = f"""
	<!DOCTYPE html>
    <html>
    <head>
        <title>{unique_id}</title>
    </head>
    <body>
        <h1>Your unique account ID: {unique_id}</h1>
        <p><a href="/check?uuid={unique_id}">Click here to check if you are a winner!</a></p>
    </body>
    </html>
	"""
	r = Response(html)
	r.set_cookie("id",unique_id)
	return r

def normalize_uuid(uuid: str):
	uuid_l = list(uuid)
	i = 0
	for i in range(len(uuid)):
		uuid_l[i] = uuid_l[i].upper()
		if uuid_l[i] == "-":
			uuid_l.pop(i)
			uuid_l.append(" ")

	return "".join(uuid_l)

def make_cache_key():
	return f"GET_check_uuids:{normalize_uuid(request.args.get('uuid'))}"[:64]


check_bp = Blueprint("check_bp", __name__)

@check_bp.route("/check")
@cache.cached(timeout=604800, make_cache_key=make_cache_key)
def check():
	user_uuid = request.args.get("uuid")
	if not user_uuid:
		return {"Error":"UUID is required!"},400
	run_query("UPDATE uuids SET value = value + 1 WHERE id=%s;",(user_uuid,))
	
	res = run_query("SELECT * FROM uuids WHERE id=%s;",(user_uuid,))
	g.cache_hit = False
	if "affected_rows" not in res:
		print("Error:",res)
		return "ERRORRRR"
	if res["affected_rows"] == 0:
		return "Invalid account ID"
	num_wins = res["result"][0]["value"]
	if num_wins >= 100:
		return f"""CONGRATS! YOU HAVE WON.............. A FLAG! {os.getenv("FLAG")}"""
	return f"""<p>Congrats! You have won! Only {100 - res["result"][0]["value"]} more wins to go.</p>
    <p>Next attempt allowed at: {(datetime.datetime.now() + datetime.timedelta(days=7)).isoformat(sep=" ")} UTC</p><p><a href="/">Go back to the homepage</a></p>"""

@check_bp.after_request
def add_cache_header(response):
    if hasattr(g, "cache_hit") and not g.cache_hit:
        response.headers["X-Cached"] = "MISS"
    else:
        response.headers["X-Cached"] = "HIT"

    g.cache_hit = True

    return response


app.register_blueprint(check_bp)

if __name__ == "__main__":
	app.run(debug=True)