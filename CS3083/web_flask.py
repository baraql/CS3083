from flask import Flask, render_template, request
import mysql.connector

app = Flask(__name__)

config = {
  'user': 'root',
  'password': '',
  'host': 'localhost',
  'database': 'JailSystem',
  'raise_on_warnings': True
}

# Route for the main page
@app.route('/')
def index():
    conn = mysql.connector.connect(**config)
    cursor = conn.cursor(dictionary=True)
    
    cursor.execute('SELECT * FROM criminals')
    criminals = cursor.fetchall()
    print(criminals)

    cursor.close()
    conn.close()

    return render_template('index.html', criminals=criminals)


@app.route('/crimes/<int:criminal_id>')
def crimes(criminal_id):
    conn = mysql.connector.connect(**config)
    cursor = conn.cursor(dictionary=True)
    
    cursor.execute('SELECT * FROM crimes WHERE criminal_ID = %s', (criminal_id,))
    crimes = cursor.fetchall()

    cursor.close()
    conn.close()

    return render_template('crimes.html', crimes=crimes, criminal_id=criminal_id)

if __name__ == '__main__':
    app.run(debug=True)

