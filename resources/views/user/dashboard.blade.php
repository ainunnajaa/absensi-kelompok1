<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            margin: 10px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .link {
            display: inline-block;
            margin-top: 20px;
            font-size: 14px;
            color: #007BFF;
            text-decoration: none;
        }

        .link:hover {
            text-decoration: underline;
        }

        footer {
            margin-top: 20px;
            font-size: 12px;
            color: #aaa;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, {{ Auth::user()->name }}</h1>

        <!-- Check In Form -->
        <form action="{{ route('user.attendance.checkin') }}" method="POST" style="margin-bottom: 20px;">
            @csrf
            <button type="submit" class="btn">Check In</button>
        </form>

        <!-- Check Out Form -->
        <form action="{{ route('user.attendance.checkout') }}" method="POST" style="margin-bottom: 20px;">
            @csrf
            <button type="submit" class="btn btn-secondary">Check Out</button>
        </form>

        <!-- Attendance Summary Link -->
        <a href="{{ route('user.attendance.summary') }}" class="link">View Monthly Attendance</a>
    </div>

    <footer>
        &copy; 2024 Attendance System. All rights reserved.
    </footer>
</body>
</html>
