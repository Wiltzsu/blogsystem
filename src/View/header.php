<?php 



error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blog Posts</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://cdn.tiny.cloud/1/ocpxbj8oq8ujrkdaxy8x84l388iz9uji8ut7xut77wz4xlef/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> <!-- WYSIWYG TinyMCE editor -->
</head>

<?php
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">My Website</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
                    <span class="navbar-text">
                        Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </span>
                <?php endif; ?>
                
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="profile.php">Profile <span class="sr-only">(current)</span></a>
                </li>

                <?php if (isset($_SESSION['loggedin']) && $_SESSION['username'] == 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link" href="admin_panel.php">Admin Panel <span class="sr-only">(current)</span></a>
                </li>
                <?php endif; ?>

                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout <span class="sr-only">(current)</span></a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/blog/src/View/login_view.php">Login <span class="sr-only">(current)</span></a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
