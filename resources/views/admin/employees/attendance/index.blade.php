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
            <h3>Attendance Summary</h3>
        </div>
        <div>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </nav>

    <div class="container">
        <h2>Attendance Records</h2>

        <table>
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Present</th>
                    <th>Absent</th>
                    <th>Late</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->employee->name }}</td>
                    <td>{{ $attendance->present_count }}</td>
                    <td>{{ $attendance->absent_count }}</td>
                    <td>{{ $attendance->late_count }}</td>
                    <td>
                        <a href="{{ route('admin.attendance.show', $attendance->id) }}">View</a>
                        <a href="{{ route('admin.attendance.update', $attendance->id) }}">Edit</a>
                        <form action="{{ route('admin.attendance.destroy', $attendance->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
