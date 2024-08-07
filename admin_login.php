<?php
session_start();
require 'db_connection.php'; // Adjust the path to your database connection script

// Initialize variables
$login_error = "";

// Check if the user is already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: admin.html");
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminid = trim($_POST['adminid']);
    $password = trim($_POST['password']);

    // Simple validation
    if (empty($adminid) || empty($password)) {
        $login_error = "Both fields are required!";
    } else {
        // Prepare SQL statement
        $stmt = $conn->prepare("SELECT * FROM admin WHERE adminid = ? AND password = ?");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("ss", $adminid, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows == 1) {
            // Start session and redirect to admin page
            $_SESSION['loggedin'] = true;
            header("Location: admin.html");
            exit;
        } else {
            $login_error = "Invalid username or password!";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>

    .login-container {
        max-width: 400px;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
        background-color: rgb(94, 31, 237);
        border: none;
    }

    .toast {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1050;
    }
    .password-wrapper {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        cursor: pointer;
    }
    </style>
</head>

<body>
    <div class="login-container">
        <h2 class="text-center">Admin Login</h2>
        <?php if ($login_error) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($login_error); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php endif; ?>
        <form action="admin_login.php" method="post">
            <div class="form-group">
                <label for="adminid">Username</label>
                <input type="text" class="form-control" id="adminid" name="adminid" required>
            </div>
            <div class="form-group password-wrapper">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
    </div>

    <!-- Toast Container -->
    <div class="toast" id="toast" style="display: none;">
        <div class="toast-body" id="toast-message"></div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    function showToast(message, type) {
        var toast = document.getElementById('toast');
        var toastMessage = document.getElementById('toast-message');
        toastMessage.textContent = message;
        toast.className = 'toast bg-' + type;
        toast.style.display = 'block';
        setTimeout(function() {
            toast.style.display = 'none';
        }, 5000);
    }

    <?php if ($login_error) : ?>
    showToast("<?php echo htmlspecialchars($login_error); ?>", "danger");
    <?php elseif (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) : ?>
    showToast("Login successful!", "success");
    <?php endif; ?>
    </script>
</body>

</html>