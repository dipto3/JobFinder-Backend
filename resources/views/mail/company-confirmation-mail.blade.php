<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Verify Email</title>
</head>

<body>
    <h2>Welcome, {{ $user->name }}</h2>

    <p>Thank you for registering your company.</p>

    <p>Please click the button below to verify your email address:</p>

    <p>
        <a href="{{ $verificationUrl }}"
            style="display: inline-block; padding: 10px 20px; background-color: #4CAF50; 
                  color: white; text-decoration: none; border-radius: 4px;">
            Verify Email
        </a>
    </p>

    <p>If you did not create an account, no further action is required.</p>

    <p>Thanks,<br>{{ config('app.name') }}</p>
</body>

</html>
