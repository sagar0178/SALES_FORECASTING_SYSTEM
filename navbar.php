<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
    /* Ensure the dropdown menu fits within the viewport */
    .dropdown-menu {
        position: absolute;
        /* Ensure it's positioned relative to the parent */
        transform: translateX(-40%);
        /* Center the menu horizontally */
        left: 0;
        /* Start from the left edge of the parent */
    }

    /* Additional styles to handle viewport overflow */
    .dropdown-menu.show {
        display: block;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="admin.html">Admin Panel</a>
        <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span> -->
        <!-- </button> -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="notifications.html">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M8.645 20.5a3.502 3.502 0 0 0 6.71 0zM3 19.5h18v-3l-2-3v-5a7 7 0 1 0-14 0v5l-2 3z" />
                        </svg>
                        <!-- Notifications -->
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="0.88em" height="1em" viewBox="0 0 448 512">
                            <path fill="currentColor"
                                d="M224 256a128 128 0 1 0 0-256a128 128 0 1 0 0 256m-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512h388.6c16.4 0 29.7-13.3 29.7-29.7c0-98.5-79.8-178.3-178.3-178.3z" />
                        </svg>
                        <!-- Admin -->
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="profile.html">Profile</a>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var dropdownToggle = document.getElementById('navbarDropdown');
        var dropdownMenu = dropdownToggle.nextElementSibling;

        function adjustDropdownPosition() {
            var rect = dropdownToggle.getBoundingClientRect();
            var menuWidth = dropdownMenu.offsetWidth;
            var viewportWidth = window.innerWidth;

            if (rect.left + menuWidth > viewportWidth) {
                dropdownMenu.style.left = 'auto';
                dropdownMenu.style.right = '0';
            } else {
                dropdownMenu.style.left = '0';
                dropdownMenu.style.right = 'auto';
            }
        }

        dropdownToggle.addEventListener('click', function() {
            adjustDropdownPosition();
            // Toggle menu visibility
            if (dropdownMenu.classList.contains('show')) {
                dropdownMenu.classList.remove('show');
            } else {
                dropdownMenu.classList.add('show');
            }
        });

        window.addEventListener('resize', adjustDropdownPosition);
    });
    </script>
</body>

</html>