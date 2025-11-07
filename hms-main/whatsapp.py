from flask import Flask,request
import sys
from whatsfly import WhatsApp
app = Flask(__name__)

@app.route("/")
def hello_world():
    args = request.args
    phone = args.get("phone")
    message = args.get("message")
    chat = WhatsApp()
    chat.send_message(phone=phone, message=message)
    # return as json success
    return " "

if __name__ == "__main__":
    from waitress import serve
    serve(app, host="104.238.176.133", port=5000)

