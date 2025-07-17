<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Summary of Password Reset Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
    </style>
</head>
<body>

    <h1>Reset Password</h1>

    <p>Dear <span style="color:blue;"> {{ $username }}, </span></p>

    <p>Use this link to reset your password</p>
    <p> <span style="font-weight: bold;">Link :</span> {{ $resetUrl }}. </p>

</body>
</html>
