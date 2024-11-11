@extends('welcome')

@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between align-items-center heading_div">
            <div class="head_text">
                <h2>User Profile</h2>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center" id="imgContainer">
                            @if ($user['photo'] == null)
                                <i id="profile_icon" class="fas fa-user-circle profile-icon"></i>
                            @else
                                <img src="http://127.0.0.1:8000/images/{{ $user['photo'] }}" style="width: 100px !important;" alt="">
                            @endif
                        </div>
                        <div class="text-center mt-3">
                            <h5>{{ $user['full_name'] }}</h5>
                            <p>{{ $user['email'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5>Profile Information</h5>
                        <hr>
                        <div class="form-group">
                            <label for="name">Email</label>
                            <input type="text" class="form-control" id="email" name="email"
                                value="{{ $user['email'] }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $user['full_name'] }}">
                        </div>
                        <div class="form-group">
                            <label for="name">Photo</label>
                            <input style="padding: 4px;" type="file" class="form-control" id="photo" name="photo">
                        </div>

                        <div class="form-group">
                            <label for="name">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone"
                                value="{{ $user['phone_no'] }}">
                        </div>

                        <button id="updateProfileBtn" class="btn btn-primary font-semibold">Update Profile</button>
                        <script>
                            document.getElementById('updateProfileBtn').addEventListener('click', function() {
                                var fullName = document.getElementById("name").value;
                                var phoneNo = document.getElementById("phone").value;
                                var photo = document.getElementById("photo").files[0]; // Get the file object
                                var uid = localStorage.getItem('uid');
                                var authorizationToken = localStorage.getItem('Authorization');
                                var apiUrl = 'https://quick-sos.onrender.com/update-profile'

                                var formData = new FormData(); // Create FormData object
                                formData.append('fullName', fullName);
                                formData.append('phoneNo', phoneNo);
                                formData.append('photo', photo); // Append file to FormData

                                // Make AJAX request
                                fetch(apiUrl, {
                                        method: 'POST',
                                        headers: {
                                            'Authorization': authorizationToken
                                        },
                                        body: formData // Send FormData instead of JSON
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        console.log(data);
                                        if (data && data.url) { // Check if data and data.url are available
                                            var imgElement = document.createElement('img');
                                            imgElement.src = 'http://127.0.0.1:8000/images/' + data.url; 
                                            imgElement.alt = 'Alternate Text'; 
                                            imgElement.width = '100';
                                            document.getElementById("profile-icon").src = 'http://127.0.0.1:8000/images/' + data.url; 
                                            var imgContainer = document.getElementById('imgContainer');
                                            // Clear previously appended elements in imgContainer
                                            imgContainer.innerHTML = '';
                                            // Append the new image element to imgContainer
                                            imgContainer.appendChild(imgElement);
                                        } else {
                                            console.error('Invalid data received.');
                                        }
                                    })
                                    .catch(error => {
                                        console.log(error);
                                    });
                            });
                        </script>

                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
