<!-- resources/views/welcome.blade.php -->

@extends('welcome')

@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between align-items-center heading_div">
            <div class="head_text">
                <h2>Groups</h2>
            </div>
            <div class="btns">
                <button class="bigbtn btn btn-primary font-semibold" onclick="createGroup()">Create Group</button>
            </div>
        </div>

        <div class="mt-2 row">
            <div class="col-md-3">
                <!-- Left container with width 30% -->
                <div class="tabs-container d-flex">
                    <div class="tab d-flex">
                        <div class="tag_div">
                            <a href="#" class="tab_name active" onclick="filterQR('all', this)">All</a> <!-- Active tab -->
                        </div>
                        <div class="tag_div">
                            <a href="#" class="tab_name" onclick="filterQR('myGroups', this)">My Groups</a>
                        </div>
                    </div>
                </div>
                <div class="container qr_box my-3" data-group="myQR" onclick="changeContent(this, 'My QR')">
                    <span class="text">My QR</span>
                </div>
                <div class="container qr_box my-3" data-group="fatherQR" onclick="changeContent(this, 'Father QR')">
                    <span class="text">Father QR</span>
                </div>
                <div class="container qr_box my-3" data-group="motherQR" onclick="changeContent(this, 'Mother QR')">
                    <span class="text">Mother QR</span>
                </div>
                <div class="container qr_box my-3" data-group="brotherQR" onclick="changeContent(this, 'Brother QR')">
                    <span class="text">Brother QR</span>
                </div>
                <div class="container qr_box my-3" data-group="grandFatherQR" onclick="changeContent(this, 'GrandFather QR')">
                    <span class="text">GrandFather QR</span>
                </div>
                <div class="container qr_box my-3" data-group="grandMotherQR" onclick="changeContent(this, 'GrandMother QR')">
                    <span class="text">GrandMother QR</span>
                </div>
            </div>    
            <div class="col-md-9" id="rightSideContainer">
                <div class="container d-flex justify-content-between">
                    <div class="head_text">
                        <h5 id="rightHeading">Select Group to show Detail</h5>
                    </div>
                </div>
            </div>
        </div>


        <script>
           function filterQR(group, element) {
                var tabs = document.querySelectorAll('.tab_name');
                tabs.forEach(function(tab) {
                    tab.classList.remove('active');
                });
                element.classList.add('active');

                var qrBoxes = document.querySelectorAll('.qr_box');
                qrBoxes.forEach(function(qrBox) {
                    if (group === 'all') {
                        qrBox.style.display = 'block';
                    } else if (group === 'myGroups') {
                        var groupAttribute = qrBox.getAttribute('data-group');
                        if (groupAttribute === 'grandFatherQR' || groupAttribute === 'grandMotherQR') {
                            qrBox.style.display = 'block';
                        } else {
                            qrBox.style.display = 'none';
                        }
                    }
                });
            }


            function changeContent(element, groupName) {
                // Load HTML content of '/group_details_page' into the right-side container
                var rightSideContainer = document.getElementById('rightSideContainer');
                var url = '/group_details?groupName=' + encodeURIComponent(groupName); // Include the groupName in the URL
                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        rightSideContainer.innerHTML = html;
                        // Change background color and text color of clicked qr_box
                        element.style.backgroundColor = '#00262b';
                        element.querySelector('.text').style.color = 'white';
                        // Reset background color and text color of other qr_boxes
                        var qrBoxes = document.querySelectorAll('.qr_box');
                        qrBoxes.forEach(function(qrBox) {
                            if (qrBox !== element) {
                                qrBox.style.backgroundColor = '';
                                qrBox.querySelector('.text').style.color = '';
                            }
                        });
                    })
                    .catch(error => console.error('Error fetching group details page:', error));
            }


            function createGroup() {
                var rightContainer = document.getElementById('rightSideContainer');
                // Clear previous content
                rightContainer.innerHTML = '';
                
                // Load form HTML from create_qr_form.blade.php using fetch API
                fetch('/create_group_form')
                    .then(response => response.text())
                    .then(html => {
                        rightContainer.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error fetching form HTML:', error);
                    });
            }

            function add_member_form(){
                var rightContainer = document.getElementById('rightSideContainer');
                // Clear previous content
                rightContainer.innerHTML = '';
                
                // Load form HTML from create_qr_form.blade.php using fetch API
                fetch('/add_member_form')
                    .then(response => response.text())
                    .then(html => {
                        rightContainer.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error fetching form HTML:', error);
                    });
            }
        </script>
    </div>
    <!-- Your homepage content goes here -->
@endsection
