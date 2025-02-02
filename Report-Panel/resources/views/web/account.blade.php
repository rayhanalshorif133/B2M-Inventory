<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <title>Account</title>
</head>


<body class="bg-light">
    <div class="container py-5">
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="d-flex justify-content-between p-2">
                <div class="d-flex justify-content-start p-2">
                    <a href="{{ route('home') }}"><i class="fa-solid fa-arrow-left text-black fs-5"></i></a>
                </div>
                <div class="d-flex justify-content-end p-2">
                    <button class="btn btn-outline-info btn-sm editBtn"><i class="fa-solid fa-pen-to-square"></i>
                        Edit</button>
                    <button class="btn btn-outline-success btn-sm checkBtn d-none"><i class="fa-solid fa-check"></i>
                        Submit</button>
                </div>
            </div>

            @guest
                <div>
                    You are a GUEST your
                </div>
            @else
                <div class="card-body text-center info-container">
                    <img src="{{ asset($profile_image) }}" alt="avatar" class="rounded-circle mb-3"
                        style="width: 150px; height: 150px; object-fit: cover;">
                    <h5 class="card-title">{{ Auth::user()->name }}</h5>
                    <p class="card-text">
                        <strong>Phone:</strong> {{ Auth::user()->phone }}
                    </p>
                </div>
                <div class="card-body text-left form-container d-none">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group py-2">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" value="{{ Auth::user()->name }}"
                                class="form-control">
                        </div>
                        <div class="form-group py-2">
                            <label for="image">Profile Picture</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-outline-success btn-sm checkBtn d-none"><i
                                class="fa-solid fa-check"></i>
                            Update</button> 
                        <button type="button" class="btn btn-outline-danger btn-sm cancelBtn d-none">
                            <i class="fa-solid fa-xmark"></i>
                            Cancel</button>
                    </form>


                </div>
                <div class="w-fit text-center d-none">
                    <a class="btn btn-sm btn-danger mb-3" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <br />
                </div>
            @endguest
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".editBtn").click(function() {
                $(".editBtn").addClass('d-none');
                $(".checkBtn").removeClass('d-none');
                $(".cancelBtn").removeClass('d-none');
                $(".info-container").addClass('d-none');
                $(".form-container").removeClass('d-none');
            });

            $(".cancelBtn").click(function() {
                $(".editBtn").removeClass('d-none');
                $(".checkBtn").addClass('d-none');
                $(".cancelBtn").addClass('d-none');
                $(".info-container").removeClass('d-none');
                $(".form-container").addClass('d-none');
            });
        });
    </script>

</body>

</html>
