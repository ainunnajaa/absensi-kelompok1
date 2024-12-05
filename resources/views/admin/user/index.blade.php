<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            padding: 40px;
            text-align: center;
        }

        h1 {
            font-size: 32px;
            color: #333;
            margin-bottom: 20px;
        }

        .profile-image {
            margin: 20px 0;
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 6px solid #007bff;
        }

        .card {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        .card h2 {
            font-size: 24px;
            color: #007bff;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 16px;
            color: #555;
        }

        .btn {
            display: inline-block;
            padding: 15px 35px;
            font-size: 18px;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            margin: 15px 10px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #28a745;
        }

        .btn-secondary:hover {
            background-color: #218838;
        }

        footer {
            margin-top: 30px;
            font-size: 12px;
            color: #aaa;
            text-align: center;
        }

        .status-message {
            font-size: 16px;
            color: #28a745;
            margin-top: 20px;
        }

        .status-error {
            font-size: 16px;
            color: #dc3545;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Profile Image and Welcome Message -->
        <img src="https://www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}?s=150&d=mm" alt="User Profile Picture" class="profile-image">
        <h1>Welcome, {{ Auth::user()->name }}</h1>

        <!-- Card Section -->
        <div class="card">
            <h2>Dashboard Overview</h2>
            <p>Manage your attendance and view your profile details.</p>
        </div>

        <!-- Check In and Check Out Buttons -->
        <form action="{{ route('user.attendance.checkin') }}" method="POST" style="margin-bottom: 20px;">
            @csrf
            <button type="submit" class="btn">Check In</button>
        </form>

        <form action="{{ route('user.attendance.checkout') }}" method="POST" style="margin-bottom: 20px;">
            @csrf
            <button type="submit" class="btn btn-secondary">Check Out</button>
        </form>

        <!-- Attendance Summary Link -->
        <a href="{{ route('user.attendance.summary') }}" class="btn">View Monthly Attendance</a>

        <!-- Success or Error Message -->
        @if(session('success'))
            <div class="status-message">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="status-error">{{ session('error') }}</div>
        @endif
    </div>

    <footer>
        &copy; 2024 Attendance System. All rights reserved.
    </footer>

</body>
</html>
