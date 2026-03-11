<?php
error_reporting(E_ALL);
ini_set('display_errors', 1); 

session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']); 
    $password = trim($_POST['password']); 

    
    if (empty($username) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all fields.']);
        exit;
    }

   
    $stmt = $conn->prepare("SELECT * FROM korisnici WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            echo json_encode(['status' => 'success', 'message' => 'Login successful.']);
            exit;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid username or password.']);
            exit;
        }
    }
        
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-image: url('assets/background.jpg'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            height: 100vh; 
            display: flex;
            justify-content: center; 
            align-items: center; 
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9); 
            padding: 30px 20px; 
            border-radius: 10px; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); 
            width: 100%;
            max-width: 400px; 
            text-align: center; 
        }

        h1 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Login</h1>
    <div id="error-message" class="alert alert-danger" style="display: none;"></div>
    <div id="success-message" class="alert alert-success" style="display: none;"></div>
    <form id="loginForm">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Login</button>
        <button type="button" class="btn btn-secondary btn-block mt-2" onclick="window.location.href='register.php';">
            Don't have an account? Register
        </button>
    </form>
</div>
</body>
</html>



<script>
    $(document).ready(function() {
        $('#loginForm').on('submit', function(e) {
            e.preventDefault(); 

            
            const username = $('#username').val();
            const password = $('#password').val();

            
            $.ajax({
                url: 'login.php', 
                method: 'POST',
                data: { username: username, password: password },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#success-message').text(response.message).show();
                        $('#error-message').hide();
                        setTimeout(() => {
                            window.location.href = 'about_us.php'; 
                        }, 2000);
                    } else {
                        $('#error-message').text(response.message).show();
                        $('#success-message').hide();
                    }
                },
                error: function() {
                    $('#error-message').text('An error occurred while processing the request.').show();
                    $('#success-message').hide();
                }
            });
        });
    });
</script>

</body>
</html>

