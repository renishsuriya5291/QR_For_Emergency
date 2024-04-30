<!-- resources/views/welcome.blade.php -->

@extends('welcome')

@section('content')
<div class="container w-50">
    <div class="full-height">
        
        <div class="container">
            <div class="container text-center">
                <h2>
                    <span class="text font-bold">
                        Sign In
                    </span>
                </h2>
            </div>
            <form>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="container d-flex justify-content-center">
                    <button type="submit" class="col-md-3 btn btn-primary btn-block">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Another section with buttons -->
    <div class="container mt-2">
        <div class="row justify-content-between">
            <div class="col">
                <a href="/auth/google" class="btn btn-outline-primary btn-block">Signin with Google</a>
            </div>
            <div class="col">
                <button class="btn btn-outline-primary btn-block">Signin with Facebook</button>
            </div>
        </div>
    </div>
</div>
@endsection
