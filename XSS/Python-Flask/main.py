from flask import Flask, redirect, url_for, request, render_template
from flask_sqlalchemy import SQLAlchemy

app=Flask(__name__)

app.config['SQLALCHEMY_DATABASE_URI'] = "mysql+mysqlconnector://root:password@localhost:3306/sqli?charset=utf8mb4&collation=utf8mb4_general_ci"
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
db = SQLAlchemy(app)

class Content(db.Model):
	id = db.Column(db.Integer, primary_key=True)
	title = db.Column(db.String(255), nullable=False)
	content= db.Column(db.Text, nullable=False)

@app.route('/status/<status_>/')
def status(status_):
	return render_template('status.html', message=status_)

@app.route('/index/', methods=['GET','POST'])
def index():
	if request.method == "POST":
		title = request.form['title']
		content = request.form['content']
		status_message = f"{title} Berhasil Ditambah"
		new_content = Content(title=title, content=content)
		db.session.add(new_content)
		db.session.commit()

		return redirect(url_for('status', status_=status_message))

	contents = Content.query.all()
	return render_template('index.html', contents=contents)



if __name__ == "__main__":
	app.run(debug=True)