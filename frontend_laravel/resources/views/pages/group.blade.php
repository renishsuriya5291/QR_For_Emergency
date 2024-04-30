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
                            <a href="#" class="tab_name active" onclick="filterQR('all', this)">All</a>
                            <!-- Active tab -->
                        </div>
                        <div class="tag_div">
                            <a href="#" class="tab_name" onclick="filterQR('myGroups', this)">My Groups</a>
                        </div>
                    </div>
                </div>
                @foreach ($data['data'] as $item)
                    <div class="container qr_box my-3" data-group="{{$item['group_created_by'] == Session::get('uid') ? "myGroup": "group"}}" onclick="changeContent(this, '{{ $item['id'] }}', '{{ $item['name'] }}')">
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


            function changeContent(element, id, groupName) {
                // Load HTML content of '/group_details_page' into the right-side container
                var rightSideContainer = document.getElementById('rightSideContainer');
                var url = '/group_details?id=' + encodeURIComponent(id) + '&groupName=' + encodeURIComponent(groupName); // Include the groupName in the URL
                localStorage.setItem('group_id', id);
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
                        const userId = localStorage.getItem('uid');
                        const authorizationToken = localStorage.getItem('Authorization');
                        fetch(`http://127.0.0.1:65535/api/v0/user/${userId}/family-group/${id}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': authorizationToken
                        },
                        })
                        .then(response => response.json())
                        .then(data => {
                            data = Object.values(data)[0];
                            console.log(data);
                           
                            var parentContainer = document.getElementById('qrDetails');
                            localStorage.setItem("members", JSON.stringify(data))

                            // Loop through the keyvalueArray
                            data.forEach(function(item) {
                                // Create container element
                                var container = document.createElement('div');
                                container.classList.add('container', 'qr_field_detail', 'my-3');
                                
                                var textC = document.createElement('div');
                                textC.classList.add('text-container');

                                // Create field element
                                var fieldElement = document.createElement('span');
                                fieldElement.classList.add('text');
                                fieldElement.innerText ="Email :";

                                // Create value element
                                var valueElement = document.createElement('span');
                                valueElement.classList.add('text');
                                valueElement.innerText = " " + item['email'];

                                // Append field and value elements to container
                                textC.appendChild(fieldElement);
                                textC.appendChild(valueElement);

                                container.appendChild(textC)

                                // Append container to parent container
                                parentContainer.appendChild(container);

                                var binIcon = document.createElement('div');
                                binIcon.classList.add('bin-container');
                                binIcon.style.cursor = 'pointer'
                                // binIcon.onclick = deleteBtnFunc;

                                var icon = document.createElement('i');
                                icon.classList.add('fas', 'fa-trash-alt', 'bin-icon')

                                binIcon.appendChild(icon)
                                container.appendChild(binIcon)
                                
                            });

                            // Select all elements with class name "bin-icon"
                            var binIcons = document.querySelectorAll('.bin-icon');

                            // Loop through binIcons and attach click event listener to each
                            binIcons.forEach(function(binIcon) {
                                binIcon.addEventListener('click', function() {
                                    // Extract email from preceding sibling element
                                    var email = this.parentElement.previousElementSibling.lastElementChild.textContent.trim();
                                    // Print the email
                                    userInput = confirm("Are you sure you want to delete this user ?")
                                    if(userInput){
                                        console.log(email);
                                        
                                        fetch(`http://127.0.0.1:65535/api/v0/user/${userId}/family-group/${id}`, {
                                            method: 'PUT',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'Authorization': authorizationToken
                                            },
                                            body: JSON.stringify({
                                                "email": email,
                                                "action": "Remove"
                                            })
                                        }).then((response) => {
                                            return response.json();
                                        }).then((data) =>{
                                            console.log(data);
                                            window.location.reload();
                                        }).catch((error) => {
                                            console.error('Error:', error);
                                        });
                                    }
                                });
                            });

                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Handle errors here
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

            function submitAddMember(id){
                var email = document.getElementById('emailInput').value;
                var authorization = localStorage.getItem('Authorization');
                var uid = '<?php echo Session::get('uid'); ?>';
                var groupId = localStorage.getItem('group_id');

                fetch(`http://127.0.0.1:65535/api/v0/user/${uid}/family-group/${groupId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': authorization
                    },
                    body: JSON.stringify({
                        "email": email,
                        "action": "Add"
                    })
                }).then((response) => {
                    return response.json();
                }).then((data) =>{
                    if(data.error){
                        alert(data.error.message);
                    }else{
                        window.location.reload();
                    }
                }).catch((error) => {
                    console.error('Error:', error);
                });
            }


            
        </script>
    </div>
    <!-- Your homepage content goes here -->
@endsection
