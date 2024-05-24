<?php
namespace App\View;

use App\Model\BlogPostModel;
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