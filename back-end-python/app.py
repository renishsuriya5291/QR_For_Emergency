from flask import Flask, request, send_file
import pyqrcode
from pyqrcode import QRCode
from PIL import Image
import os
from flask_cors import CORS
import time


app = Flask(__name__)
# Allow all origins with CORS
CORS(app, resources={r"/*": {"origins": "*"}})

def generate_qr_with_logo(url, logo_path):
    qr = pyqrcode.create(url)
    qr_file = f'QR_CODE_{time.time()}.png'
    qr.png(qr_file, scale=10)

    # Open QR code image and logo image
    qr_image = Image.open(qr_file)
    logo = Image.open(logo_path)

    # Calculate position to place the logo at the center
    pos = ((qr_image.size[0] - logo.size[0]) // 2, (qr_image.size[1] - logo.size[1]) // 2)

    # Paste logo on QR code
    qr_image.paste(logo, pos)

    # Save the final image
    qr_image.save(qr_file)

    return qr_file

@app.route('/generate_qr', methods=['POST'])
def generate_qr():
    url = request.json.get('url')
    logo_path = 'logo.png'  # Adjust the path to your logo image

    if not url:
        return {'error': 'URL not provided'}, 400

    qr_file = generate_qr_with_logo(url, logo_path)

    return send_file(qr_file, mimetype='image/png')

if __name__ == '__main__':
    app.run(host='0.0.0.0', debug=True)
