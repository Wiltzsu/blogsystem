<?php
require "header.php";

try {
    // Get user id from session to be used in search query
    $user_id = $_SESSION['user_id'];
    // Query the database
    $query = "SELECT username, email FROM users WHERE user_id = '$user_id'";
    // Execute the query and return the result set as a PDOstatement object
    $data = $pdo->query($query);
    // Fetch the next row as an object
    $rows = $data->fetch(PDO::FETCH_OBJ);

    // If there are any rows found, set the current values to variables
    if ($rows) {
        $current_username = $rows->username;
        $current_email = $rows->email;

        // If 'send' is clicked in the form, update values in the database
        if (isset($_POST['send'])) {
            //$new_user_id = $_POST['user_id'];
            $new_username = $_POST['username'];
            //$new_password = $_POST['password'];
            $new_email = $_POST['email'];

            $update = "UPDATE users
                        SET username = :new_username, 
                        email = :new_email
                        WHERE user_id = :current_user_id";

            // Prepare the update statement
            $updateStatement = $pdo->prepare($update);

            // Bind parameters to values
            $updateStatement->bindParam(':new_username', $new_username);
            $updateStatement->bindParam(':new_email', $new_email);
            $updateStatement->bindParam(':current_user_id', $user_id);

            // Execute the update
            $updateStatement->execute();
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

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