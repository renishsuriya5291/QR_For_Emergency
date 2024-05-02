<!-- resources/views/welcome.blade.php -->

@extends('welcome')

@section('content')
    <div class="container w-50">
        <div class="full-height">

            <div class="container">
                <div class="container text-center">
                    <h2>
                        <span class="text font-bold">
                            Sign Up
                        </span>
                    </h2>
                </div>
                {{-- <form id="signupForm">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password">
                </div>
                <div class="container d-flex justify-content-center">
                    <button type="button" id="submitForm" class="col-md-3 btn btn-primary btn-block">Submit</button>
                </div>
            </form> --}}
                <!-- Another section with buttons -->
                <div class="container mt-5">
                    <div class="row justify-content-between">
                        <div class="col">
                            <a href="/auth/google" class="btn btn-outline-primary btn-block">Signup with Google</a>
                        </div>
                        <div class="col">
                            <a href="/auth/facebook" class="btn btn-outline-primary btn-block">Signup with Facebook</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
@endsection
