<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        
        body, html {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #1c1c1c;
            color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            transition: background-color 0.3s, color 0.3s;
        }

        .login-container {
            background-color: #333;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            font-size: 2em;
        }

        .login-container label {
            display: block;
            margin-bottom: 10px;
            font-size: 1.1em;
        }

        .login-container input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
        }

        .login-container input[type="submit"] {
            background-color: #76a9ff;
            color: #333;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-container input[type="submit"]:hover {
            background-color: #558bff;
        }

        .login-container a {
            color: #76a9ff;
            text-decoration: none;
            margin-top: 10px;
            display: inline-block;
        }

        .login-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h2>Login</h2>

    <form action="loginProcess.php" method="POST">
        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" required>
        <input type="submit" value="Login">
    </form>

    <p><a href="index.php">Return to Home</a></p>
    </div>
</body>
</html>
