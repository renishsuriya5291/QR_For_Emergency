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

        <div class="mt-2 row">
            <div class="col-md-3">
                <!-- Left container with width 30% -->
                <div class="container qr_box" onclick="changeContent(this, 'My QR')">
                    <span class="text">My QR</span>
                </div>
                <div class="container qr_box my-3" onclick="changeContent(this, 'Father QR')">
                    <span class="text">Father QR</span>
                </div>
                <div class="container qr_box my-3" onclick="changeContent(this, 'Mother QR')">
                    <span class="text">Mother QR</span>
                </div>
                <div class="container qr_box my-3" onclick="changeContent(this, 'Brother QR')">
                    <span class="text">Brother QR</span>
                </div>
                <div class="container qr_box my-3" onclick="changeContent(this, 'GrandFather QR')">
                    <span class="text">GrandFather QR</span>
                </div>
                <div class="container qr_box my-3" onclick="changeContent(this, 'GrandMother QR')">
                    <span class="text">GrandMother QR</span>
                </div>
            </div>
            <div class="col-md-9" id="rightContainer">
                <div class="container d-flex justify-content-between">
                    <div class="head_text">
                        <h5 id="rightHeading">QR Code Detail</h5>
                    </div>
                    <div class="btns" id="exportBtnContainer" style="display: none;">
                        <button class="btn btn-primary font-semibold">Export QR</button>
                    </div>
                </div>

                <div class="container mt-5" id="qrDetails" style="display: none;">
                    <div class="container qr_field_detail my-3">
                        <span class="text">Number : </span>
                        <span class="text">+91 12345 09876</span>
                    </div>
                    <div class="container qr_field_detail my-3">
                        <span class="text">Emergency Number : </span>
                        <span class="text">+91 12365 09876</span>
                    </div>
                    <div class="container qr_field_detail my-3">
                        <span class="text">Address : </span>
                        <span class="text">Surat, Gujarat</span>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            // Function to set default text when page loads
            window.onload = function() {
                var rightHeading = document.getElementById('rightHeading');
                rightHeading.innerText = 'Select QR to show Details';
            };
            
            function changeContent(element, text) {
                var rightHeading = document.getElementById('rightHeading');
                rightHeading.innerText = text;
                
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
            }

            function createQR() {
                var rightContainer = document.getElementById('rightContainer');
                // Clear previous content
                rightContainer.innerHTML = '';
                
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
                }
            }



        </script>

         
    </div>
    <!-- Your homepage content goes here -->
@endsection
