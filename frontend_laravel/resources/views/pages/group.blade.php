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
        @php
            print_r($data);
        @endphp
        <div class="mt-2 row">
            <div class="col-md-3">
                <!-- Left container with width 30% -->
                <div class="tabs-container d-flex">
                    <div class="tab d-flex">
                        <div class="tag_div">
                            <a href="#" class="tab_name active" onclick="filterQR('all', this)">All</a>
                            <!-- Active tab -->
                        </div>
                        <div class="tag_div">
                            <a href="#" class="tab_name" onclick="filterQR('myGroups', this)">My Groups</a>
                        </div>
                    </div>
                </div>
                {{-- <div class="container qr_box my-3" data-group="group" onclick="changeContent(this, 'My QR')">
                    <span class="text">My QR</span>
                </div>
                <div class="container qr_box my-3" data-group="group" onclick="changeContent(this, 'Father QR')">
                    <span class="text">Father QR</span>
                </div>
                <div class="container qr_box my-3" data-group="group" onclick="changeContent(this, 'Mother QR')">
                    <span class="text">Mother QR</span>
                </div>
                <div class="container qr_box my-3" data-group="group" onclick="changeContent(this, 'Brother QR')">
                    <span class="text">Brother QR</span>
                </div>
                <div class="container qr_box my-3" data-group="myGroup"
                    onclick="changeContent(this, 'GrandFather QR')">
                    <span class="text">GrandFather QR</span>
                </div>
                <div class="container qr_box my-3" data-group="myGroup"
                    onclick="changeContent(this, 'GrandMother QR')">
                    <span class="text">GrandMother QR</span>
                </div> --}}
                @foreach ($data['data'] as $item)
                    <div class="container qr_box my-3" data-group="group" onclick="changeContent(this, '{{ $item['name'] }}')">
                        <span class="text">{{ $item['name'] }}</span>
                    </div>
                @endforeach

               
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
                        if (groupAttribute === 'myGroup') {
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

            function add_member_form() {
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

            function submitGroup() {
                var name = document.getElementById('nameInput').value;
                var authorization = localStorage.getItem('Authorization');
                var uid = '<?php echo Session::get('uid'); ?>';


                fetch(`http://127.0.0.1:65535/api/v0/user/${uid}/family-group`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': authorization
                    },
                    body: JSON.stringify({
                        groupName: name
                    })
                }).then((response) => {
                    return response.json();
                }).then(data =>
                    // reload the page 
                    window.location.reload()
                ).catch((error) => {
                    console.error('Error:', error);
                });
            }
        </script>
    </div>
    <!-- Your homepage content goes here -->
@endsection
