<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #4CAF50, #81C784);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            color: #fff;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.15);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            width: 100%;
            max-width: 400px;
        }

        .login-container h1 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 2rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 8px;
            outline: none;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.9);
            color: #333;
        }

        .form-group input:focus {
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
        }

        .submit-btn {
            display: block;
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 8px;
            background: #4CAF50;
            color: #fff;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .submit-btn:hover {
            background: #388E3C;
        }

        .footer {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .footer a {
            color: #FFD700;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="submit-btn">Login</button>
        </form>
        <div class="footer">
            <p>Don't have an account? <a href="/register">Register</a></p>
        </div>
    </div>
</body>
</html>
