<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Already Verified</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f4f8;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .card {
            background: white;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        .card h2 {
            color: #2d3748;
            margin-bottom: 15px;
        }

        .card p {
            color: #4a5568;
            margin-bottom: 25px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3182ce;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background-color: #2563eb;
        }
    </style>
</head>
<body>

    <div class="card">
        <h2>🔔 Email Already Verified</h2>
        <p>This email address has already been verified.</p>
        <a href="http://localhost:5173" class="btn">Go to Login</a>
    </div>

</body>
</html>
