<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f9;
        }
        nav {
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
        }
        nav a {
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
        }
        nav a:hover {
            background: #388E3C;
        }
        .container {
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        .actions {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .btn {
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background: #388E3C;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>

    <nav>
        <div>
            <h3>Admin Dashboard</h3>
        </div>
        <div>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </nav>

    <div class="container">
        <h2>Welcome to the Admin Dashboard</h2>

        <div class="actions">
            <a href="" class="btn">Manage Employees</a>
            <a href="" class="btn">View Attendance</a>
        </div>

        <h3>Recent Attendance Summary</h3>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Present</th>
                    <th>Absent</th>
                    <th>Late</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through attendance data -->
                @foreach($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->employee->name }}</td>
                    <td>{{ $attendance->present_count }}</td>
                    <td>{{ $attendance->absent_count }}</td>
                    <td>{{ $attendance->late_count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
