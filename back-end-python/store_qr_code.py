import requests

url = 'http://localhost:5000/generate_qr'
data = {'url': 'Hello, World'}

response = requests.post(url, json=data)
with open('./images/qr_code.png', 'wb') as f:
    f.write(response.content)
