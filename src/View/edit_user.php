<?php
ini_set('log_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

require "header.php";
?>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <form method="POST" action="edit_user.php?user_id=<?php echo $user_id; ?>">


                <div class="mb-2">
                    <label for="inputUsername" class="sr-only">New username</label>
                        <input name="username" type="text" class="form-control" id="inputUsername" placeholder="Username"
                            <?php // If input is empty, fill it with the current username
                            if (!empty($current_username)) {
                                echo 'value="' . $current_username . '"';
                            }
                            ?>>
                </div>

                <div class="mb-2">
                    <label for="inputEmail" class="sr-only">New email</label>
                        <input name="email" type="text" class="form-control" id="inputEmail" placeholder="Email"
                            <?php // If input is empty, fill it with the current email
                            if (!empty($current_email)) {
                                echo 'value="' . $current_email . '"';
                            }
                            ?>>
                </div>

                <button name="send" type="submit" class="btn btn-warning mb2">Update</button>

            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>