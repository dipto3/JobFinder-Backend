<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome to {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f9fc;
            margin: 0;
            padding: 0;
        }
        .email-container {
            background-color: #ffffff;
            width: 90%;
            max-width: 600px;
            margin: 30px auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2d3748;
        }
        p {
            color: #4a5568;
            line-height: 1.6;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            background-color: #4f46e5;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h1>Welcome, {{ $user->name }}!</h1>
        <p>
            Thank you for joining <strong>{{ config('app.name') }}</strong>. We're excited to have you on board.
        </p>
        <p>
            You can now explore your dashboard and start using our services.
        </p>
        <a href="{{ url('/dashboard') }}" class="btn">Go to Home</a>
        <p style="margin-top: 40px; font-size: 12px; color: #a0aec0;">
            If you did not sign up for this account, please ignore this email.
        </p>
    </div>
</body>
</html>
