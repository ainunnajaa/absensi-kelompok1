<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Summary</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #e5e5e5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 50px auto;
            background: #fff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 40px;
        }

        h1 {
            font-size: 28px;
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #007BFF;
            color: white;
        }

        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tr:hover {
            background-color: #f1f1f1;
        }

        .link {
            display: inline-block;
            margin-top: 20px;
            font-size: 16px;
            color: #007BFF;
            text-decoration: none;
            transition: text-decoration 0.3s ease;
            text-align: center;
        }

        .link:hover {
            text-decoration: underline;
        }

        footer {
            margin-top: 30px;
            font-size: 12px;
            color: #aaa;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Attendance Summary for {{ Auth::user()->name }}</h1>

        <!-- Attendance Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendances as $attendance)
                    <tr>
                        <td>{{ $attendance->date }}</td>
                        <td>{{ $attendance->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Back to Dashboard Link -->
        <a href="{{ route('user.dashboard') }}" class="link">Back to Dashboard</a>
    </div>

    <footer>
        &copy; 2024 Attendance System. All rights reserved.
    </footer>

</body>
</html>
