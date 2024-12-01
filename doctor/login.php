<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Prepare SQL statement
    $stmt = $con->prepare("SELECT * FROM doctor_log WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $user; // Set session variable for user
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }

    $stmt->close();
    $con->close();
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
            background: #f2f2f2;
        }
        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .login-container {
            background: #fff;
            padding: 70px;  /* Increased padding */
            box-shadow: 1px 1.732px 15px 0px rgba(0, 0, 0, 0.1);  /* Enhanced shadow for a larger effect */
            width: 400px;   /* Increased width */
            border: 1px solid #f3f3f3;
            text-align: center;
            border-radius: 8px;  /* Added border-radius for rounded corners */
        }
        .login-container h2 {
            color: #00A885;
            font-size: 26px;  /* Increased font size */
            margin-bottom: 20px;  /* Added margin below the title */
        }
        .form-control {
            height: 50px;  /* Increased input height */
            background: #ffffff;
            border: 1px solid #d9d9d9;
            font-size: 16px;  /* Increased font size for inputs */
        }
        .input-group-text {
            background: #00A885;
            color: white;
        }
        .btn-custom {
            background: #00A885;
            color: #fff;
            font-size: 22px;  /* Increased button font size */
            width: 100%;
            padding: 10px;  /* Added padding for button */
        }
        .show-password {
            position: absolute;
            right: 10px;
            top: 12px;  /* Adjusted position */
            cursor: pointer;
        }
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            color: #00A885;
            text-decoration: none;
        }
        .back-button i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <a href="../osna/index.php" class="back-button"><i class="fa fa-arrow-left"></i>Back</a>
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
                            window.location.href = 'doctor_dash.php';
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
