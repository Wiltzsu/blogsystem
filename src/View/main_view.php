<?php
require "header.php";
?>

<body>
    <div class="container">

        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-4">The blog</h1>
                <p class="lead">This is a modified jumbotron that occupies the entire horizontal space of its parent.</p>
            </div>
        </div>

        <?php
        if(isset($_SESSION['user_id'])) {
            // Display create blog post button only if user is logged in
            ?>
            <button type="button" class="btn btn-primary" onclick="location.href='create_blogpost.php'">Create Blog Post</button>
            <?php
        }
        ?>

        <h1>Blog Posts</h1>
        <div>
            <?php foreach ($blogposts as $blogpost): ?>
                <div class="blog-post">
                    <h2><?php echo htmlspecialchars($blogpost['title']); ?></h2>
                    <p><?php echo htmlspecialchars($blogpost['content']); ?></p>
                    <p>Posted by: <?php echo htmlspecialchars($blogpost['username']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
