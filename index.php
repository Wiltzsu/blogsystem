<?php
include "header.php";
?>

<body>
    <div class="container">

        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-4">The blog</h1>
                <p class="lead">This is a modified jumbotron that occupies the entire horizontal space of its parent.</p>
            </div>
        </div>

        <h1>Blog Posts</h1>

        <?php
        if(isset($_SESSION['user_id'])) {
            // Display create blog post button only if user is logged in
            ?>
            <button type="button" class="btn btn-primary" onclick="location.href='create_blogpost.php'">Create Blog Post</button>
            <?php
        }
        ?>


        <?php
        // Include get_blogposts for fetching and displaying posts
        include 'get_blogposts.php';
        // Check if file exists and is readable
        if(file_exists("data.json") && is_readable("data.json")) {
            // Get the contents and assign them to a variable
            $json_data = file_get_contents("data.json");
            // Decodes a JSON into a PHP value and stores it in a variable
            $posts = json_decode($json_data, true);
        }

        // Check if the decoded data is an array
        if(is_array($posts)) {
            // These nested loops iterates over a multi-dimensional array of posts in $posts
            foreach($posts as $key) {
                foreach($key as $post) {
                    ?>
                    <div class="row mt-4"> <!-- Add margin top to create space between posts -->
                        <div class="col"> <!-- Use Bootstrap grid to layout the title and content -->
                            <!-- Display title -->
                            <h3><?php echo $post['title'];?></h3>
                            <!-- Display content -->
                            <p><?php echo $post['content'];?></p>
                            <!-- Display username -->
                            <p>Posted by: <?php echo $post['username'];?></p>

                            <?php
                            // Check if the logged in user is the author of the post
                            if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['user_id']) {
                                // Display buttons only if user is logged in
                                ?>
                            <button type="button" class="btn btn-info" onclick="location.href='update_blogpost.php?id=<?php echo $post['id']; ?>'">Update Blog Post</button>
                            <button type="button" class="btn btn-secondary" onclick="location.href='delete_blogpost.php?id=<?php echo $post['id']; ?>'">Delete Blog Post</button>
                            <?php    
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
            }
        }
        ?>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
