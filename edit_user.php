<?php
include "header.php";

try {
    // Get user id from session to be used in search query
    $user_id = $_SESSION['user_id'];
    // Query the database
    $query = "SELECT * FROM users WHERE user_id = '$user_id'";
    // Execute the query and return the result set as a PDOstatement object
    $data = $pdo->query($query);
    // Fetch the next row as an object
    $rows = $data->fetch(PDO::FETCH_OBJ);

    // If there are any rows found, set the current values to variables
    if ($rows) {
        $current_user_id = $rows->user_id;
        $current_username = $rows->username;
        $current_password = $rows->password;
        $current_email = $rows->email;

        // If 'send' is clicked in the form, update values in the database
        if (isset($_POST['send'])) {
            $new_user_id = $_POST['user_id'];
            $new_username = $_POST['username'];
            $new_password = $_POST['password'];
            $new_email = $_POST['email'];

            $update = "UPDATE users
                        SET user_id = :new_user_id, username = :new_username, password = :new_password, email = :new_email
                        WHERE user_id = :current_user_id";

            // Prepare the update statement
            $updateStatement = $pdo->prepare($update);

            // Bind parameters to values
            $updateStatement->bindParam(':new_user_id', $new_user_id);
            $updateStatement->bindParam(':new_username', $new_username);
            $updateStatement->bindParam(':new_password', $new_password);
            $updateStatement->bindParam(':new_email', $new_email);
            $updateStatement->bindParam(':current_user_id', $current_user_id);

            // Execute the update
            $updateStatement->execute();
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <form method="POST" action="edit_user.php?user_id=<?php echo $user_id; ?>">

            <div class="mb-2">
                <label for="inputUserId" class="sr-only">New user id</label>
                    <input name="user_id" type="text" class="form-control" id="inputUserId" placeholder="User id"
                        <?php // If input is empty, fill it with the current username
                        if (!empty($current_user_id)) {
                            echo 'value="' . $current_user_id . '"';
                        }
                ?>>
            </div>

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

            <div class="mb-2">
                <label for="inputPassword" class="sr-only">New password</label>
                    <input name="password" type="text" class="form-control" id="inputPassword" placeholder="Password"
                        <?php // If input is empty, fill it with the current email
                        if (!empty($current_password)) {
                            echo 'value="' . $current_password . '"';
                        }
                ?>>
            </div>     

            <button name="send" type="submit" class="btn btn-warning mb2">Update</button>

        </div>
    </div>
</div>