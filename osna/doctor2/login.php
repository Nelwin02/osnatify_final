<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // PostgreSQL query (using parameterized query)
    $query = "SELECT * FROM doctor_log WHERE username = $1 AND password = $2";
    $result = pg_query_params($con, $query, array($username, $password));

    if ($result && pg_num_rows($result) > 0) {
        $_SESSION['username'] = $username; // Set session variable for user
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }

    // Free result and close connection
    pg_free_result($result);
    pg_close($con);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
         body {
            background: url('assets/img/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Arial', sans-serif;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-container h2 {
            color: #007BFF;
            margin-bottom: 20px;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #ddd;
            height: 45px;
            border-radius: 5px;
            font-size: 16px;
        }

        .input-group-text {
            background: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px 0 0 5px;
        }

        .btn-custom {
            background: #007BFF;
            color: #fff;
            font-size: 18px;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .btn-custom:hover {
            background: #0056b3;
        }

        .show-password {
            position: absolute;
            right: 15px;
            top: 10px;
            cursor: pointer;
        }

        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            color: #fff;
            text-decoration: none;
            font-size: 18px;
        }

        .back-button i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <a href="../index.php" class="back-button"><i class="fa fa-arrow-left"></i>Back</a>
    <div class="container">
        <div class="login-container">
            <h2>Doctor Login</h2>
            <div id="alert-container"></div>
            <form id="loginForm">
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        </div>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                        <span class="show-password" onclick="togglePasswordVisibility()">
                            <i class="fa fa-eye"></i>
                        </span>
                    </div>
                </div>
                <button type="submit" class="btn btn-custom">Login</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password');
            var passwordIcon = document.querySelector('.show-password i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }

        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            window.location.href = 'doctor_dash2.php';
                        } else {
                            $('#alert-container').html("<div class='alert alert-danger' role='alert'>Invalid username or password!</div>");
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
