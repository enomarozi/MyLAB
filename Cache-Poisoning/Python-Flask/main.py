from flask import Flask, redirect, url_for, request, render_template
from flask_sqlalchemy import SQLAlchemy
import uuid

app=Flask(__name__)

app.config['SQLALCHEMY_DATABASE_URI'] = "mysql+mysqlconnector://admin:password@localhost:3306/sqli?charset=utf8mb4&collation=utf8mb4_general_ci"
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
db = SQLAlchemy(app)

class Content(db.Model):
	id = db.Column(db.Integer, primary_key=True)
	uuid = db.Column(db.String(50), nullable=False)

def normalize_uuid(uuid: str):
	uuid_l = list(uuid)
@app.route('/status/<status_>/')
def status(status_):
	return render_template('status.html', message=status_)

@app.route('/', methods=['GET','POST'])
def index():
	print("Request cookies: ", request.cookies)
	print("Request args: ", request.args)
	if "id" not in request.cookies:
		unique_id = str(uuid.uuid4())
		print(unique_id)

	return f"Cookies: {request.cookies}, Request Args: {request.args}"

if __name__ == "__main__":
	app.run(debug=True)