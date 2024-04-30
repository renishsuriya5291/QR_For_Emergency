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
                            <button onclick="updateQR(this, '{{ $item['id'] }}')" class="btn btn-primary font-semibold">Update QR</button>
                        </div>
                        <div class="btns" id="exportBtnContainer" style="display: none;">
                            <button class="btn btn-primary font-semibold">Export QR</button>
                        </div>
                    </div>
                </div>

                <div class="container mt-5" id="qrDetails" style="display: none;">
                    <div class="container qr_field_detail my-3">
                        <span class="text" id="field"></span>
                        <span class="text" id="value"></span>
                    </div>
                    {{-- <div class="container qr_field_detail my-3">
                        <span class="text">Emergency Number : </span>
                        <span class="text">+91 12365 09876</span>
                    </div>
                    <div class="container qr_field_detail my-3">
                        <span class="text">Address : </span>
                        <span class="text">Surat, Gujarat</span>
                    </div> --}}
                </div>
            </div>
        </div>

        <div id="Authorization" data-token="{{ Session::get('Authorization') }}"></div>
        <div id="uid"  data-token="{{ Session::get('uid') }}"></div>

        
        <script>
            // Function to set default text when page loads
            window.onload = function() {
                var rightHeading = document.getElementById('rightHeading');
                rightHeading.innerText = 'Select QR to show Details';

            };
            
            function changeContent(element, uid) {
                var rightHeading = document.getElementById('rightHeading');
                const authorizationToken = document.getElementById('Authorization').dataset.token;

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
                document.getElementById('updateBtnContainer').style.display = 'block';

                // Call the API
                fetch(`http://192.168.118.113:65535/api/v0/user/113667327802780860519/qr-code/${uid}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': authorizationToken
                    },
                })
                .then(response => response.json())
                .then(data => {
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

            function updateQR(element, uid) {
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
                            fieldDiv.innerHTML = '<span class="text">' + item['field'] + ':</span><span class="text">' + item['value'] + '</span>';
                            // Attach click event listener to the div
                            fieldDiv.addEventListener('click', function() {
                                // Print the data of the clicked div in the console
                                console.log('Clicked div data:', item);
                                document.getElementById("ukeyInput").value = item['field']
                                document.getElementById("uvalueInput").value = item['value']
                                document.getElementById("ubtn").innerText = "Update"
                                document.getElementById("ubtn").onclick = UpdateQRFunc

                            });

                            document.getElementById('ufieldsDiv').appendChild(fieldDiv);
                            // Get existing QRCodeData from local storage or initialize empty array
                            var existingQRCodeData = JSON.parse(localStorage.getItem('QRCodeData')) || { data: [] };

                            // Add new key-value pair to QRCodeData
                            existingQRCodeData.data.push({ field: item['field'], value: item['value'] });

                            // Store updated QRCodeData in local storage
                            localStorage.setItem('QRCodeData', JSON.stringify(existingQRCodeData));
                        });

                        


                        // Append new field div to the fields div

                    })
                    .catch(error => {
                        console.error('Error fetching form HTML:', error);
                    });


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
                    fieldDiv.innerHTML = '<span class="text">' + keyInput + ':</span><span class="text">' + valueInput + '</span>';

                    // Append new field div to the fields div
                    document.getElementById('fieldsDiv').appendChild(fieldDiv);

                    // Clear input fields
                    document.getElementById('keyInput').value = '';
                    document.getElementById('valueInput').value = '';

                    // Get existing QRCodeData from local storage or initialize empty array
                    var existingQRCodeData = JSON.parse(localStorage.getItem('QRCodeData')) || { data: [] };

                    // Add new key-value pair to QRCodeData
                    existingQRCodeData.data.push({ field: keyInput, value: valueInput });

                    // Store updated QRCodeData in local storage
                    localStorage.setItem('QRCodeData', JSON.stringify(existingQRCodeData));
                }
            }
            

            function uaddKeyValue(){
                var keyInput = document.getElementById('ukeyInput').value.trim();
                var valueInput = document.getElementById('uvalueInput').value.trim();

                // Check if key and value are not empty
                if (keyInput !== '' && valueInput !== '') {
                    // Show the fields div
                    document.getElementById('ufieldsDiv').style.display = 'block';

                    // Create new field div
                    var fieldDiv = document.createElement('div');
                    fieldDiv.classList.add('container', 'qr_field_detail', 'my-3');
                    fieldDiv.innerHTML = '<span class="text">' + keyInput + ':</span><span class="text">' + valueInput + '</span>';

                    // Append new field div to the fields div
                    document.getElementById('ufieldsDiv').appendChild(fieldDiv);

                    // Clear input fields
                    document.getElementById('ukeyInput').value = '';
                    document.getElementById('uvalueInput').value = '';
                    
                    // Get existing QRCodeData from local storage or initialize empty array
                    var existingQRCodeData = JSON.parse(localStorage.getItem('QRCodeData')) || { data: [] };

                    // Add new key-value pair to QRCodeData
                    existingQRCodeData.data.push({ field: keyInput, value: valueInput });

                    // Store updated QRCodeData in local storage
                    localStorage.setItem('QRCodeData', JSON.stringify(existingQRCodeData));
                }
            }

            async function create_qr_submit (){
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
                    const response = await fetch(`http://192.168.118.113:65535/api/v0/user/${uid}/qr-code`, {
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
                        body: JSON.stringify({ value: data.data.Authorization })
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

            async function update_qr_submit(){

            }


        </script>

         
    </div>
    <!-- Your homepage content goes here -->
@endsection
