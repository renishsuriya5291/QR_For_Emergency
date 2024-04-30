colors 
primary 
#00262b


secondary
#d23228


background color 
color: #e1dddb;


add kreli field key value pair ma fill nathi thatu
update button pr click kre pchi localstorage ma update thavu joia and update api call 



Home backup:
@extends('welcome')

@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between align-items-center heading_div">
            <div class="head_text">
                <h2>QR Code</h2>
            </div>
            <div class="btns">
                <button class="bigbtn btn btn-primary font-semibold">Create QR</button>
            </div>
        </div>

        <div class="mt-2 row">
            <div class="col-md-3">
                <!-- Left container with width 30% -->
                <div class="container qr_box" onclick="changeContent('My QR')">
                    <span class="text">My QR</span>
                </div>
                <!-- Repeat other qr_box divs here -->
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
                    <!-- Content fetched dynamically will be inserted here -->
                </div>
            </div>
        </div>
        
        <script>
            // Function to set default text when page loads
            window.onload = function() {
                var rightHeading = document.getElementById('rightHeading');
                rightHeading.innerText = 'Select QR to show Details';
            };
            
            async function changeContent(text) {
                var rightHeading = document.getElementById('rightHeading');
                rightHeading.innerText = text;
                
                // Hide the export button initially
                document.getElementById('exportBtnContainer').style.display = 'none';
                
                // Show the second container
                var qrDetails = document.getElementById('qrDetails');
                qrDetails.style.display = 'block';
                
                // Clear previous content
                qrDetails.innerHTML = '';
                
                try {
                    // Fetch data from API based on selected QR
                    const response = await fetch('your_api_url/' + text);
                    const data = await response.json();
                    
                    // Generate HTML based on API response
                    const html = `
                        <div class="container qr_field_detail my-3">
                            <span class="text">Number : </span>
                            <span class="text">${data.number}</span>
                        </div>
                        <div class="container qr_field_detail my-3">
                            <span class="text">Emergency Number : </span>
                            <span class="text">${data.emergencyNumber}</span>
                        </div>
                        <div class="container qr_field_detail my-3">
                            <span class="text">Address : </span>
                            <span class="text">${data.address}</span>
                        </div>
                    `;
                    
                    // Insert generated HTML into qrDetails container
                    qrDetails.innerHTML = html;
                    
                    // Show the export button
                    document.getElementById('exportBtnContainer').style.display = 'block';
                } catch (error) {
                    console.error('Error fetching data:', error);
                }
            }
        </script>
    </div>
    <!-- Your homepage content goes here -->
@endsection
