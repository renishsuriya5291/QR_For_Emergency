from flask import Flask, request, send_file
import pyqrcode
from pyqrcode import QRCode
import os
from flask_cors import CORS
import time


app = Flask(__name__)
CORS(app)

@app.route('/generate_qr', methods=['POST'])
def generate_qr():
    url = request.json.get('url')

    if not url:
        return {'error': 'URL not provided'}, 400

    qr = pyqrcode.create(url)
    qr_file = f'QR_CODE_{time.time()}.png'
    qr.png(qr_file, scale=10)

    return send_file(qr_file, mimetype='image/png')

if __name__ == '__main__':
    app.run(host='0.0.0.0', debug=True)