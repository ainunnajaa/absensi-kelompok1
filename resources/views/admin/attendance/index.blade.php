<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance List</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            position: relative;
        }

        h1 {
            text-align: center;
            color: #333;
            padding: 20px;
            background-color: #4CAF50;
            color: white;
        }

        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #388E3C;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        a {
            color: white;
            background-color: #4CAF50;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #388E3C;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        button {
            padding: 5px 10px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #d32f2f;
        }

        .message {
            background-color: #e7f7e7;
            color: #4CAF50;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 20px;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>

    <h1>Attendance List</h1>

    <!-- Logout Button with form submission -->
    <a href="#" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="container">
        <a href="{{ route('admin.attendance.create') }}">Add New Attendance</a>
        <a href="{{ route('admin.dashboard') }}" class="btn">Back to Dashboard</a>  <!-- Corrected link -->

        @if(session('success'))
            <div class="message">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="message error">{{ session('error') }}</div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendances as $attendance)
                    <tr>
                        <td>{{ $attendance->employee->name }}</td>
                        <td>{{ $attendance->status }}</td>
                        <td>{{ $attendance->attendance_date }}</td>
                        <td>
                            <a href="{{ route('admin.attendance.edit', $attendance->id) }}">Edit</a>
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
