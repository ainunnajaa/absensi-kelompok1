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
            align-items: center;
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
        @media (max-width: 768px) {
            nav {
                flex-direction: column;
                align-items: flex-start;
            }
            .actions {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>

    <nav>
        <div>
            <h3>Admin Dashboard</h3>
        </div>
        <div>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); if(confirm('Are you sure you want to logout?')) document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </nav>

    <div class="container">
        <h2>Welcome to the Admin Dashboard</h2>

        <!-- Summary Section -->
        <div class="actions">
            <a href="{{ route('employees.index') }}" class="btn">Manage Employees</a>
            <a href="{{ route('admin.attendance.index') }}" class="btn">View Attendance</a>
        </div>

        <h3>Recent Attendance Summary</h3>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Waktu Absen Masuk</th>
                    <th>Waktu Absen Keluar</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if($attendances->isEmpty())
                    <tr>
                        <td colspan="4" style="text-align: center;">No attendance data available</td>
                    </tr>
                @else
                    @foreach($attendances as $attendance)
                    <tr>
                        <td>{{ $attendance->employee->name }}</td>
                        <td>{{ $attendance->check_in ? $attendance->check_in : '-' }}</td>
                        <td>{{ $attendance->check_out ? $attendance->check_out : '-' }}</td>
                        <td>
                            <a href="{{ route('admin.attendance.edit', $attendance->id) }}" class="btn">Edit</a>
                            <form action="{{ route('admin.attendance.destroy', $attendance->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn" style="background: #f44336;">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</body>
</html>
