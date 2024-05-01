@extends('welcome')

@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between align-items-center heading_div">
            <div class="head_text">
                <h2>QR Code</h2>
            </div>
            <div class="btns">
                <button class="bigbtn btn btn-primary font-semibold" onclick="createQR()">Create QR</button>
            </div>
        </div>

        <div class="mt-2 row" id="mainContainer">
            <div class="col-md-3" id="leftContainer">
                @foreach ($data['data'] as $item)
                    <div class="container qr_box my-3" onclick="changeContent(this, '{{ $item['id'] }} QR')">
                        <span class="text">{{ $item['title'] }}</span>
                    </div>
                @endforeach
            </div>

            <div class="col-md-9" id="rightContainer">
                <div class="container d-flex justify-content-between">
                    <div class="head_text">
                        <h5 id="rightHeading">QR Code Detail</h5>
                    </div>
                    
            
                    <div class="buttons d-flex ">
                        <div class="btns px-2" id="updateBtnContainer" style="display: none;">
                            <button onclick="updateQR(this)" class="btn btn-primary font-semibold">Update QR</button>
                        </div>
                        <div class="btns px-2" id="exportBtnContainer" style="display: none;">
                            <button class="btn btn-primary font-semibold" onclick="exportQR(this)">Export QR</button>
                        </div>
                        <div class="btns" id="deleteBtnContainer" style="display: none;">
                            <button onclick="deleteQR(this)" class="btn btn-primary font-semibold">Delete QR</button>
                        </div>
                    </div>
                </div>

                <div class="container mt-5" id="qrDetails" style="display: none;">
                    <div class="container qr_field_detail my-3">
                        <span class="text" id="field"></span>
                        <span class="text" id="value"></span>
                    </div>
                </div>
                <div id="qrCodeContainer" style="text-align: center;">
            
                </div>
            </div>
        </div>

        

        <script>
            localStorage.setItem('Authorization', "{{ Session::get('Authorization') }}");
            localStorage.setItem('uid', "{{ Session::get('uid') }}");
        </script>
        <div id="Authorization" data-token="{{ Session::get('Authorization') }}"></div>
        <div id="uid" data-token="{{ Session::get('uid') }}"></div>


        <script>
            // Function to set default text when page loads
            window.onload = function() {
                var rightHeading = document.getElementById('rightHeading');
                rightHeading.innerText = 'Select QR to show Details';

            };

            function changeContent(element, uid) {
                localStorage.setItem('qrid', uid);
                var rightHeading = document.getElementById('rightHeading');
                const authorizationToken = document.getElementById('Authorization').dataset.token;
                const userId = document.getElementById('uid').dataset.token;

                var qrBoxes = document.querySelectorAll('.qr_box');
                qrBoxes.forEach(function(qrBox) {
                    qrBox.style.backgroundColor = '';
                    qrBox.querySelector('.text').style.color = '';
                });

                element.style.backgroundColor = '#00262b';
                element.querySelector('.text').style.color = 'white';

                // Show the second container
                document.getElementById('qrDetails').style.display = 'block';
                // Show the export button
                document.getElementById('exportBtnContainer').style.display = 'block';
                document.getElementById('deleteBtnContainer').style.display = 'block';
                document.getElementById('updateBtnContainer').style.display = 'block';

                // Call the API
                fetch(`http://127.0.0.1:65535/api/v0/user/${userId}/qr-code/${uid}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': authorizationToken
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        localStorage.setItem("qrhash", data.data.hash);
                        // Handle the JSON response
                        // Show the second container
                        document.getElementById('qrDetails').style.display = 'block';
                        document.getElementById('qrDetails').innerHTML = '';

                        // Show the export button
                        const keyvalueArray = Object.values(data.data.data)[0];
                        // Assuming you have a parent container where you want to append the generated containers
                        var parentContainer = document.getElementById('qrDetails');
                        rightHeading.innerText = data.data.title;
                        localStorage.setItem("codedetail", JSON.stringify(data.data))

                        // Loop through the keyvalueArray
                        keyvalueArray.forEach(function(item) {
                            // Create container element
                            var container = document.createElement('div');
                            container.classList.add('container', 'qr_field_detail', 'my-3');

                            // Create field element
                            var fieldElement = document.createElement('span');
                            fieldElement.classList.add('text');
                            fieldElement.innerText = item['field'] + " :";

                            // Create value element
                            var valueElement = document.createElement('span');
                            valueElement.classList.add('text');
                            valueElement.innerText = " " + item['value'];

                            // Append field and value elements to container
                            container.appendChild(fieldElement);
                            container.appendChild(valueElement);

                            // Append container to parent container
                            parentContainer.appendChild(container);
                        });


                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Handle errors here
                    });
            }


            function createQR() {
                var rightContainer = document.getElementById('rightContainer');
                var leftContainer = document.getElementById('leftContainer');
                leftContainer.innerHTML = '';

                localStorage.removeItem('QRCodeData')

                // Change the class of the right container
                rightContainer.classList.remove('col-md-9');
                rightContainer.classList.add('col-md-12');

                // Load form HTML from create_qr_form.blade.php using fetch API
                fetch('/create_qr_form')
                    .then(response => response.text())
                    .then(html => {
                        rightContainer.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error fetching form HTML:', error);
                    });

            }

            function updateQR(element) {
                const uid = localStorage.getItem("qrid")
                var rightContainer = document.getElementById('rightContainer');
                var leftContainer = document.getElementById('leftContainer');
                leftContainer.innerHTML = '';

                localStorage.removeItem('QRCodeData');

                // Change the class of the right container
                rightContainer.classList.remove('col-md-9');
                rightContainer.classList.add('col-md-12');
                // Load form HTML from create_qr_form.blade.php using fetch API
                fetch(`/update_qr_form?uid=${uid}`)
                    .then(response => response.text())
                    .then(html => {
                        rightContainer.innerHTML = html;
                        let qrdata = JSON.parse(localStorage.getItem('codedetail'))
                        keyvaluedata = Object.values(qrdata.data)[0];
                        console.log(keyvaluedata);
                        document.getElementById("unameInput").value = qrdata.title

                        document.getElementById('ufieldsDiv').style.display = 'block';


                        keyvaluedata.forEach(function(item) {
                            // Create new field div
                            var fieldDiv = document.createElement('div');
                            fieldDiv.classList.add('container', 'qr_field_detail', 'my-3');
                            fieldDiv.innerHTML = '<span class="text">' + item['field'] +
                                ':</span><span class="text">' + item['value'] + '</span>';
                            // Attach click event listener to the div
                            fieldDiv.addEventListener('click', function() {
                                // Print the data of the clicked div in the console
                                console.log('Clicked div data:', item);
                                document.getElementById("ukeyInput").value = item['field']
                                document.getElementById("uvalueInput").value = item['value']
                                document.getElementById("ubtn").innerText = "Update"
                                // document.getElementById("ubtn").onclick = UpdateQRFunc
                            });

                            document.getElementById('ufieldsDiv').appendChild(fieldDiv);
                            // Get existing QRCodeData from local storage or initialize empty array
                            var existingQRCodeData = JSON.parse(localStorage.getItem('QRCodeData')) || {
                                data: []
                            };

                            // Add new key-value pair to QRCodeData
                            existingQRCodeData.data.push({
                                field: item['field'],
                                value: item['value']
                            });

                            // Store updated QRCodeData in local storage
                            localStorage.setItem('QRCodeData', JSON.stringify(existingQRCodeData));
                        });




                        // Append new field div to the fields div

                    })
                    .catch(error => {
                        console.error('Error fetching form HTML:', error);
                    });


            }

            function deleteQR(element) {
                userAsk = confirm("Are you sure you want to delete this QR?");
                if (userAsk) {

                    const uid = localStorage.getItem("qrid")

                    const authorizationToken = document.getElementById('Authorization').dataset.token;
                    const userId = document.getElementById('uid').dataset.token;

                    // Call the API
                    fetch(`http://127.0.0.1:65535/api/v0/user/${userId}/qr-code/${uid}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'Authorization': authorizationToken
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Handle the JSON response
                            console.log('Response:', data);
                            window.location.href = "/";

                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Handle errors here
                        });

                }

            }

            function addKeyValue() {
                var keyInput = document.getElementById('keyInput').value.trim();
                var valueInput = document.getElementById('valueInput').value.trim();

                // Check if key and value are not empty
                if (keyInput !== '' && valueInput !== '') {
                    // Show the fields div
                    document.getElementById('fieldsDiv').style.display = 'block';

                    // Create new field div
                    var fieldDiv = document.createElement('div');
                    fieldDiv.classList.add('container', 'qr_field_detail', 'my-3');
                    fieldDiv.innerHTML = '<span class="text">' + keyInput + ':</span><span class="text">' + valueInput +
                        '</span>';



                    // Append new field div to the fields div
                    document.getElementById('fieldsDiv').appendChild(fieldDiv);

                    // Clear input fields
                    document.getElementById('keyInput').value = '';
                    document.getElementById('valueInput').value = '';

                    // Get existing QRCodeData from local storage or initialize empty array
                    var existingQRCodeData = JSON.parse(localStorage.getItem('QRCodeData')) || {
                        data: []
                    };

                    // Add new key-value pair to QRCodeData
                    existingQRCodeData.data.push({
                        field: keyInput,
                        value: valueInput
                    });

                    // Store updated QRCodeData in local storage
                    localStorage.setItem('QRCodeData', JSON.stringify(existingQRCodeData));
                }
            }


            function uaddKeyValue() {
                var keyInput = document.getElementById('ukeyInput').value.trim();
                var valueInput = document.getElementById('uvalueInput').value.trim();

                // Check if key and value are not empty
                if (keyInput !== '' && valueInput !== '') {
                    // Show the fields div
                    document.getElementById('ufieldsDiv').style.display = 'block';

                    // Create new field div
                    var fieldDiv = document.createElement('div');
                    fieldDiv.classList.add('container', 'qr_field_detail', 'my-3');
                    fieldDiv.innerHTML = '<span class="text">' + keyInput + ':</span><span class="text">' + valueInput +
                        '</span>';

                    // Append new field div to the fields div
                    document.getElementById('ufieldsDiv').appendChild(fieldDiv);

                    // Clear input fields
                    document.getElementById('ukeyInput').value = '';
                    document.getElementById('uvalueInput').value = '';

                    // Get existing QRCodeData from local storage or initialize empty array
                    var existingQRCodeData = JSON.parse(localStorage.getItem('QRCodeData')) || {
                        data: []
                    };

                    // Add new key-value pair to QRCodeData
                    existingQRCodeData.data.push({
                        field: keyInput,
                        value: valueInput
                    });

                    // Store updated QRCodeData in local storage
                    localStorage.setItem('QRCodeData', JSON.stringify(existingQRCodeData));
                }
            }

            async function create_qr_submit() {
                let name = document.getElementById("nameInput").value;
                let data = localStorage.getItem('QRCodeData');
                data = JSON.parse(data);

                // Construct the request body
                let requestBody = {
                    QRCodeName: name,
                    QRCodeData: data
                };
                const authorizationToken = document.getElementById('Authorization').dataset.token;
                const uid = document.getElementById('uid').dataset.token;
                console.log(authorizationToken);
                console.log(uid);

                try {
                    const response = await fetch(`http://127.0.0.1:65535/api/v0/user/${uid}/qr-code`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': authorizationToken
                        },
                        body: JSON.stringify(requestBody)
                    });


                    // Parse the JSON response
                    const data = await response.json();

                    // Print the response data
                    console.log('Response:', data.data.Authorization);
                    fetch('/update-session', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                value: data.data.Authorization
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log(data.message); // Output: Session updated successfully
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });

                    window.location.href = "/";
                } catch (error) {
                    // Handle errors
                    console.error('Error:', error);
                }

            }

            async function update_qr_submit() {
                let name = document.getElementById("unameInput").value;
                let data = localStorage.getItem('QRCodeData');
                data = JSON.parse(data);
                // Construct the request body
                let requestBody = {
                    QRCodeName: name,
                    QRCodeData: data
                };
                // const authorizationToken = document.getElementById('Authorization').dataset.token;
                const authorizationToken = localStorage.getItem('Authorization')
                const uid = localStorage.getItem('uid')
                const qrid = localStorage.getItem('qrid')


                try {
                    const response = await fetch(`http://127.0.0.1:65535/api/v0/user/${uid}/qr-code/${qrid}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': authorizationToken
                        },
                        body: JSON.stringify(requestBody)
                    });


                    // Parse the JSON response
                    const data = await response.json();

                    // // Print the response data
                    // console.log('Response:', data);
                    // fetch('/update-session', {
                    //     method: 'POST',
                    //     headers: {
                    //         'Content-Type': 'application/json',
                    //     },
                    //     body: JSON.stringify({ value: data.data.Authorization })
                    // })
                    // .then(response => {
                    //     if (!response.ok) {
                    //         throw new Error('Network response was not ok');
                    //     }
                    //     return response.json();
                    // })
                    // .then(data => {
                    //     console.log(data.message); // Output: Session updated successfully
                    // })
                    // .catch(error => {
                    //     console.error('Error:', error);
                    // });

                    window.location.href = "/";
                } catch (error) {
                    // Handle errors
                    console.error('Error:', error);
                }

            }

            function exportQR(){
                const QRHash = localStorage.getItem("qrhash");
                const QRName = document.getElementById('rightHeading').innerText;
                const url = '127.0.0.1:8000/qr-code/' + QRHash;

                
                var apiUrl = "http://192.168.118.113:5000/generate_qr";
  
                // Request payload
                var payload = JSON.stringify({ "url": url});
                
                // Send POST request
                fetch(apiUrl, {
                    method: "POST",
                    headers: {
                    "Content-Type": "application/json"
                    },
                    body: payload
                })
                .then(response => {
                    // Convert response to blob
                    return response.blob();
                })
                .then(blob => {
                    // Create URL for the blob
                    var imgUrl = URL.createObjectURL(blob);
                    
                    // Create image element
                    var img = document.createElement("img");
                    img.src = imgUrl;
                    
                    // Append image to container
                    document.getElementById("qrCodeContainer").appendChild(img);
                    
                    // Create download link
                    var a = document.createElement("a");
                    a.href = imgUrl;
                    a.download = "qr_code.png";
                    a.textContent = "Download QR Code";
                    a.style.textDecoration = 'none'
                    a.style.color = "white"
                    a.style.backgroundColor = "#00262b"
                    a.style.padding = "10px"    

                    
                    // Append download link
                    document.getElementById("qrCodeContainer").appendChild(a);
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
                
            }
        </script>


    </div>
    <!-- Your homepage content goes here -->
@endsection
