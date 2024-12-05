<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Attendance</title>
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

        nav h3 {
            margin: 0;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        nav a:hover {
            background: #388E3C;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: 500;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }

        select, input[type="date"], input[type="time"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 5px;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background: #388E3C;
        }

        .btn-back {
            background: #f44336;
            margin-top: 10px;
            width: auto;
        }

        .btn-back:hover {
            background: #d32f2f;
        }

        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <nav>
        <div>
            <h3>Add Attendance</h3>
        </div>
        <div>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </nav>

    <div class="container">
        <h2>Enter Attendance</h2>

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.attendance.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="employee_id">Employee</label>
                <select name="employee_id" id="employee_id" required>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" required>
                    <option value="present">Present</option>
                    <option value="absent">Absent</option>
                    <option value="late">Late</option>
                </select>
            </div>

            <div class="form-group">
                <label for="attendance_date">Date</label>
                <input type="date" name="attendance_date" id="attendance_date" required>
            </div>

            <div class="form-group">
                <label for="check_in">Check-in Time</label>
                <input type="time" name="check_in" id="check_in">
            </div>

            <div class="form-group">
                <label for="check_out">Check-out Time</label>
                <input type="time" name="check_out" id="check_out">
            </div>

            <button type="submit" class="btn">Save Attendance</button>
        </form>

        <a href="{{ route('admin.attendance.index') }}" class="btn btn-back">Back to Attendance List</a>
    </div>

</body>
</html>
