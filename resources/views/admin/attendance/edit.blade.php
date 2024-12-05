<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Attendance</title>
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
    </style>
</head>
<body>

    <nav>
        <div>
            <h3>Edit Attendance</h3>
        </div>
        <div>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </nav>

    <div class="container">
        <h2>Edit Attendance for {{ $attendance->employee->name }}</h2>
        <form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div>
                <label for="present">Present</label>
                <input type="number" name="present" id="present" value="{{ $attendance->present }}" required>
            </div>

            <div>
                <label for="absent">Absent</label>
                <input type="number" name="absent" id="absent" value="{{ $attendance->absent }}" required>
            </div>

            <div>
                <label for="late">Late</label>
                <input type="number" name="late" id="late" value="{{ $attendance->late }}" required>
            </div>

            <button type="submit" class="btn">Update Attendance</button>
        </form>
    </div>
</body>
</html>
