<?php
require '../db_connection.php'; 

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } else {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT); 
        $sql = "SELECT user_id FROM users WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Username or Email already exists";
        } else {
            $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $password_hashed, $email);

            if ($stmt->execute()) {
                $success = "Registration successful!";
                header('Location: login.php');  // Redirect to login page
                exit();
            } else {
                $error = "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Register</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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
        top: 75%;
        right: 10px;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .error-message {
        color: red;
        font-size: 0.9em;
        margin-top: 5px;
    }
    </style>
</head>

<body>
    <div class="login-container">
        <h2 class="text-center">Register</h2>
        <?php if ($error && $error !== "Passwords do not match") : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($error); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php endif; ?>
        <?php if ($success) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($success); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php endif; ?>
        <form action="register.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
            </div>
            <div class="form-group password-wrapper">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <i class="fas fa-eye toggle-password" id="togglePassword"></i>
            </div>
            <div class="form-group password-wrapper">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                <i class="fas fa-eye toggle-password" id="toggleConfirmPassword"></i>
                
            </div>
            <?php if ($error === "Passwords do not match") : ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
                <?php endif; ?>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>
        <div class="text-center mt-3">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
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

    <?php if ($error && $error !== "Passwords do not match") : ?>
    showToast("<?php echo htmlspecialchars($error); ?>", "danger");
    <?php elseif ($success) : ?>
    showToast("<?php echo htmlspecialchars($success); ?>", "success");
    <?php endif; ?>

    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        var passwordField = document.getElementById('password');
        var type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });

    document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
        var confirmPasswordField = document.getElementById('confirm_password');
        var type = confirmPasswordField.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPasswordField.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });

    // Retain password values using JavaScript
    window.onload = function() {
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST") : ?>
        document.getElementById('password').value = "<?php echo isset($password) ? htmlspecialchars($password) : ''; ?>";
        document.getElementById('confirm_password').value = "<?php echo isset($confirm_password) ? htmlspecialchars($confirm_password) : ''; ?>";
        <?php endif; ?>
    };
    </script>
</body>

</html>
