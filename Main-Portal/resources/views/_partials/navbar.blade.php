@php
    $user = Auth::user();
@endphp
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/home" class="nav-link">Home</a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto px-2">
        <li class="nav-item mr-5">
            @if (!$user->password)
                <form class="d-flex" action="{{ route('user.profile') }}?type=update-password" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="text" class="form-control mx-2" required name="password" placeholder="Password" />
                    <input type="text" class="form-control mx-2"  required name="confirm_password"
                        placeholder="Confirm Password" />
                    <button type="submit" class="btn btn-sm btn-navy" style="margin: 4px 0 10px;">Update</button>
                </form>
            @endif

            @if ($user->password && !$user->email_verified_at)
                <form class="d-flex" action="{{ route('user.profile') }}?type=update-email" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="email" class="form-control mx-2" name="email" required placeholder="Enter your email" />
                    <button type="submit" class="btn btn-sm btn-navy" style="margin: 4px 0 10px;">Update</button>
                </form>
            @endif
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item mt-1">
            <a href="/user-logout" class="btn btn-sm btn-danger btnLogout">
                Logout
            </a>
        </li>
    </ul>
</nav>

<script></script>
