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
                        <div class="text-center">
                            <i class="fas fa-user-circle profile-icon"></i>
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
                            <input type="text" class="form-control" id="email" name="email" value="{{ $user['email'] }}" readonly>   
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user['full_name'] }}">   
                        </div>
                        <div class="form-group">
                            <label for="name">Photo</label>
                            <input style="padding: 4px;" type="file" class="form-control" id="photo" name="photo">   
                        </div>
                        
                        <div class="form-group">
                            <label for="name">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="{{ $user['phone_no'] }}">   
                        </div>
                        
                        <button id="updateProfileBtn" class="btn btn-primary font-semibold" >Update Profile</button>
                        <script>
                            document.getElementById('updateProfileBtn').addEventListener('click', function(){
                                // Get form data
                                var fullName = document.getElementById("name").value;
                                var phoneNo = document.getElementById("phone").value;
                                var photo = document.getElementById("photo").value; // Assuming this is a file input, you may need different handling
                                var uid = localStorage.getItem('uid');
                                var authorizationToken = localStorage.getItem('Authorization'); 
                                // API URL
                                var apiUrl = 'http://127.0.0.1:65535/api/v0/user/'+uid;
                                
                                // Request body
                                var requestBody = {
                                    fullName: fullName,
                                    phoneNo: phoneNo,
                                    photo: photo
                                };
                        
                                // Make AJAX request
                                fetch(apiUrl, {
                                    method: 'PUT',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Authorization': authorizationToken
                                    },
                                    body: JSON.stringify(requestBody)
                                })
                                .then(response => response.json())
                                .then(data => {
                                    console.log(data);
                                    if(data.error != null){
                                        alert('Error: '+ data.error.message)
                                    }
                                    
                                }) // Print response data to console
                                .catch(error => {
                                    alert('Error:', error)
                                });
                            })  
                        </script>
                                               
                    </div>
                </div>
            </div>
        </div>
      

    </div>

@endsection
