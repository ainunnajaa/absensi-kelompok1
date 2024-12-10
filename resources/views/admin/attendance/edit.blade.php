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
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }

        form div {
            margin-bottom: 15px;
        }

        form label {
            display: block;
            font-weight: 500;
            margin-bottom: 5px;
            color: #555;
        }

        form input[type="text"],
        form input[type="time"],
        form input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        form input:focus {
            border-color: #4CAF50;
            outline: none;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        }

        form button {
            width: 100%;
            font-size: 16px;
            padding: 10px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        form button:hover {
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
        <h2>Edit Attendance for {{ $attendance->judul_absensi }}</h2>
        <form action="{{ route('admin.attendance.update', $attendance->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div>
                <label for="judul_absensi">Attendance Title</label>
                <input type="text" name="judul_absensi" id="judul_absensi" value="{{ $attendance->judul_absensi }}" required>
            </div>

            <div>
                <label for="check_in">Check-In Time</label>
                <input type="time" name="check_in" id="check_in" value="{{ $attendance->check_in }}" required>
            </div>

            <div>
                <label for="check_out">Check-Out Time</label>
                <input type="time" name="check_out" id="check_out" value="{{ $attendance->check_out }}" required>
            </div>

            <div>
                <label for="tanggal_absen">Attendance Date</label>
                <input type="date" name="tanggal_absen" id="tanggal_absen" value="{{ $attendance->tanggal_absen }}" required>
            </div>

            <button type="submit">Update Attendance</button>
        </form>
    </div>

</body>
</html>
