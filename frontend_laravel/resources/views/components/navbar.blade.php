<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="/"><img src="images/logo.png" style="height: 41px;" alt=""></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link font-semibold {{ Request::is('/') ? 'active' : '' }}" href="/">QR Codes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-semibold {{ Request::is('groups') ? 'active' : '' }}" href="/groups">Groups</a>
                </li>
            </ul>
            @php
                $auth = Session::get('Authorization');
                $name = Session::get('name');
                if(isset($auth)){
                    $loggedin = 1;
                }else{
                    $loggedin = 0;
                }
            @endphp

            @if ($loggedin == true)
                <div class="ml-auto d-flex">
                    <div class="text-center position-relative">
                        <div class="profile-container mx-auto d-flex justify-content-between align-items-center" onclick="toggleDropdown()">
                            <div>
                                @if (!isset($user['photo']))
                                    <i id="profile_icon" class="fas fa-user-circle profile-icon"></i>
                                @else
                                <img class="profile-icon" id="profile-icon" src="http://127.0.0.1:8000/images/{{ $user['photo'] }}" style="width: 25px !important; border-radius: 50%; height: 27px; max-width: 100%;" alt="">
                                @endif
                                {{-- <i class="fas fa-user-circle profile-icon"></i> --}}
                            </div>
                            <div class="text-left">
                                <span class="profile-name">
                                    {{$name}}
                                </span>
                                <i class="fas fa-chevron-down down-arrow"></i>
                            </div>
                        </div>
                        <div class="dropdown-menu position-absolute" id="dropdownMenu" style="display: none; right: 0;">
                           <a class="nav-link font-semibold" href="/profile">Profile</a>
                           <a class="nav-link font-semibold" href="/signout">Logout</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="ml-auto d-flex">
                    <div class="btn-group">
                        <a href="/signin" class="btn btn-primary mr-2 font-semibold">Sign In</a>
                        <a href="/signup" class="btn btn-secondary not-italic text-base font-bold ml-1 p-2">Register now</a>
                    </div>
                </div>
            @endif
           
        </div>
    </div>
</nav>



