<?php
ini_set('log_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Post</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
    <div class="container">
        <h1>Create New Post</h1>

        <button type="button" class="btn btn-primary" onclick="location.href='index.php'">Go Back</button>

        <form action="create_blogpost.php" method="post">

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter post title" required>
            </div>
            
            <div class="form-group">
                <label for="content">Content</label>
            <!-- TinyMCE WYSIWYG -->
            <textarea id="textarea" name="content"></textarea>

            <script>
                tinymce.init({
                    selector: '#textarea'  // Adjust the selector to match your textarea's ID
                });
            </script>            </div>



            <button type="submit" class="btn btn-primary" name="save">Submit</button>
        </form>


    </div>

    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>