<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verified</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 50px;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }

        .success-icon {
            font-size: 50px;
            color: #4CAF50;
        }

        h1 {
            color: #333;
        }

        p {
            color: #666;
            margin: 10px 0;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .btn-navy {
            background-color: navy;
        }

        .btn-navy:hover {
            background-color: #000059;
        }

        .btn-danger {
            background-color: #D32F2F;
        }

        .btn-danger:hover {
            background-color: #b71414;
        }

        .error-icon {
            font-size: 50px;
            color: #D32F2F;
        }
    </style>
</head>

<body>
    <div class="container">
        @if ($type == 'success')
            <div class="success-icon">✅</div>
            <h1>Email Verified Successfully!</h1>
            <p>Thank you for verifying your email address. You can now proceed to access your account.</p>
        @endif

        @if ($type == 'already_verified')
            <div class="success-icon">✅</div>
            <h1>Email Already Verified!</h1>
            <p>Your email has already been verified. You can proceed to access your account.</p>
        @endif


        @if ($type == 'error')
            <div class="error-icon">❌</div>
            <h1>Email Verification Failed!</h1>
            <p>Verification failed. Please try again.</p>
            <a href="#" class="btn btn-danger">Retry Verification</a>
        @endif

        <a href="{{ route("home") }}" class="btn btn-navy">Go to Dashboard</a>
    </div>
</body>

</html>
