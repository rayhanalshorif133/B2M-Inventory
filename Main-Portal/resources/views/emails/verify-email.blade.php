<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify Your Email Address</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            padding: 20px;
            text-align: center;
            border: 2px solid #333;
        }

        h1 {
            color: #333;
            font-size: 24px;
        }

        p {
            color: #555;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }

        .button:hover {
            background-color: #218838;
        }

        .logo_container {
            display: inline-block;
            padding: 10px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .logo_container img {
            display: block;
            width: 100%;
            max-width: 200px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            border-radius: 8px;
        }

        .logo_container img {
            filter: drop-shadow(0 0 10px rgba(0, 0, 0, 0.2));
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
</head>

<body>
    <div class="container">
        <div>
            <div class="logo_container">
                <img src="https://baisbd.com/new_assets/img/logo.png" alt="">
            </div>
        </div>
        <h1>Please verify your email</h1>
        <p>Thank you for signing up! To complete your registration, please verify your email address by clicking the
            button below.</p>
        <a href="{{ route('email.verify', $data['token']) }}" class="button" style="color: #f4f4f9">
            Verify Now
        </a>
        <p>If you did not sign up for this account, please ignore this message.</p>
    </div>
</body>

</html>
