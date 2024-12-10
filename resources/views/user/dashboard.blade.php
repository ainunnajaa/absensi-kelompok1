<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Absensi</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Styling untuk tombol logout di pojok kanan bawah */
        .logout-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
        }

        /* Styling untuk container */
        body {
            background-color: #f4f6f9;
            font-family: 'Roboto', sans-serif;
        }

        .container {
            max-width: 800px;
            margin-top: 50px;
        }

        h1 {
            font-size: 2rem;
            color: #333;
            text-align: center;
        }

        .alert {
            font-weight: bold;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .card-body {
            padding: 20px;
        }

        .btn {
            border-radius: 5px;
        }

        .btn-primary, .btn-success {
            padding: 10px 20px;
            font-size: 1rem;
            width: 100%;
        }

        .btn-primary:hover, .btn-success:hover {
            opacity: 0.8;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .table-bordered th, .table-bordered td {
            border: 1px solid #ddd;
        }

        /* Styling untuk tombol logout */
        .logout-btn button {
            padding: 10px 20px;
            font-size: 1rem;
            background-color: #dc3545;
            color: white;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .logout-btn button:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Dashboard Absensi Karyawan</h1>

        <!-- Menampilkan pesan jika ada -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Menampilkan Status Absensi -->
        <div class="card mt-4">
            <div class="card-header">
                Absensi Hari Ini
            </div>
            <div class="card-body">
                <p><strong>Hari ini: </strong>{{ now()->toDateString() }}</p>

                @if($alreadyCheckedIn)
                    <p><strong>Anda sudah melakukan Check-in hari ini.</strong></p>
                    <form action="{{ route('user.attendance.checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Check Out</button>
                    </form>
                @else
                    <form action="{{ route('user.attendance.checkin') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Check In</button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Rekapan Kehadiran -->
        <div class="card mt-4">
            <div class="card-header">
                Rekapan Kehadiran
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $attendance)
                            <tr>
                                <td>{{ $attendance->tanggal_absen }}</td>
                                <td>{{ ucfirst($attendance->status) }}</td>
                                <td>{{ $attendance->check_in ?? 'Belum Check In' }}</td>
                                <td>{{ $attendance->check_out ?? 'Belum Check Out' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tombol Logout di pojok kanan bawah -->
    <form action="{{ route('logout') }}" method="POST" class="logout-btn">
        @csrf
        <button type="submit">Logout</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
