<!DOCTYPE html>
<html>

<head>
    <title>Threel - Verify Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #c92a2a;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h1,
        h4 {
            color: #333333;
        }

        p {
            color: #666666;
            font-size: 16px;
            line-height: 24px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #cd0303;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #f13232;
        }

        @media (max-width: 768px) {
            .container {
                width: 90%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Hello, {{ $data['name'] }}!</h1>
        <p>We have received a verification request for this email address.
            If you did not do it, please disregard this email.
            Click the link below to verify your email.</p>
        <p>This verification link will expire in {{ $data['minutes'] }} minutes.</p>
        <a href="{{ $data['url'] }}" class="btn">Verify Email Address</a>
        <p>If you're having trouble clicking the button, click the URL below instead:</p>
        <a href="{{ $data['url'] }}">{{ $data['url'] }}</a>
        <h4>Regards, Threel Management</h4>
    </div>
</body>

</html>
