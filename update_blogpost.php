<?php
require "db.php";

try {
    // Retrieve the value of the 'id' parameter from the URL query string
    $id = $_GET['id'];

    // Construct the SQL query to select the post based on the provided id
    $query = "SELECT * FROM posts WHERE id = '$id'";

    // Execute the SQL query
    $data = $pdo->query($query);

    // Fetch the result as an object
    $rows = $data->fetch(PDO::FETCH_OBJ);

    // Check if the post with the given id exists
    if ($rows) {
        // Extract the current title and content from the fetched object
        $current_title = $rows->title;
        $current_content = $rows->content;

        // Check if the 'update' form has been submitted
        if (isset($_POST['update'])) {
            // Retrieve the new title and content from the form
            $new_title = $_POST['title'];
            $new_content = $_POST['content'];

            // Construct the SQL update to update values in the database
            $update = "UPDATE posts SET title = :new_title, content = :new_content WHERE id = :id";
            
            // Prepare the SQL update statement
            $updateStatement = $pdo->prepare($update);

            // Bind the new title, content and post id parameters to the statement
            $updateStatement->bindParam(':new_title', $new_title);
            $updateStatement->bindParam(':new_content', $new_content);
            $updateStatement->bindParam(':id', $id); // Add parameter for id

            // Execute the preprared statement which updates the post in the database
            $updateStatement->execute();

            // Redirect back to index.php after deletion
            header("Location: index.php");
            exit(); // Ensure script execution stops after redirection
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Blog Post</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
    <div class="container">
        
        <h1>Update Blog Post</h1>

        <!-- Include the post id in the url to be fetched by PHP -->
        <form method="post" action="update_blogpost.php?id=<?php echo $id; ?>">

            <div class="form-group">
                <label for="title">Title</label>
                <!-- Include the current title in the form -->
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $current_title; ?>" required>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <!-- Include the current content in the form -->
                <textarea class="form-control" id="content" name="content" rows="5" required><?php echo $current_content; ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary" name="update">Update</button>

        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>