<?php
ini_set('log_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<body>
    <div class="container">
        <div class="row p-5">
            <div class="col-sm-12">
                <p>Username: <?php echo $username?></p>
                <p>Email: <?php echo $email?></p>
                <button type="button" class="btn btn-info" onclick="location.href='edit_user.php'">Edit</button>
                <button type="button" class="btn btn-info" onclick="location.href='change_user_password.php'">Change password</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>