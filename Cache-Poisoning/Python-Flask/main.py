from flask import Flask, redirect, url_for, request,Response, render_template
import uuid
import mariadb

app=Flask(__name__)

app.config["CACHE_TYPE"] = "RedisCache"
app.config["CACHE_REDIS_HOST"] = "localhost"
app.config["CACHE_DEFAULT_TIMEOUT"] = 604800

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

def query(query, params=None):
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
		query("INSERT INTO users VALUES(%s, %s);",(unique_id,0))
	else:
		unique_id = request.cookies.get("id")
		res = query("SELECT * FROM users WHERE id=%s;",(unique_id,))
		print(res,flush=True)
		if "affected_rows" not in res:
			print("Error:",res)
			return "ERROR"
		if res["affected_rows"] == 0:
			unique_id = str(uuid.uuid4())
			query("INSERT INTO users VALUES(%s, %s);",(unique_id,0))
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

@check_bp.route("/check")
@cache.cached(timeout=604800, make_cache_key=make_cache_key)
def check():
	
if __name__ == "__main__":
	app.run(debug=True)