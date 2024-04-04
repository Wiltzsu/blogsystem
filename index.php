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
        require 'get_blogposts.php';
        $posts = []; // Initialize posts array

        // Check if file exists and is readable
        if(file_exists("data.json") && is_readable("data.json")) {
            // Read the content of the JSON file and store it in a variable
            $json_data = file_get_contents("data.json");
            // Decode the JSON string into a PHP associative array
            $decoded_data = json_decode($json_data, true);
            // Access the 'posts' key of the associative array to get the posts data
            $posts = $decoded_data['posts'];
        }

        // Define how many results you want to display per page
        $results_per_page = 2;
        // Count the total number of posts available
        $total_posts = count($posts);
        // Calculate the total number of pages needed, rounding up to the nearest whole number
        $number_of_pages = ceil($total_posts / $results_per_page);

        // Check if the current page number is set in the URL and is a number
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            // If so, use this number as the current page
            $page = (int) $_GET['page'];
        } else {
            // If not, just assume we're on the first page
            $page = 1;
        }

        // Calculate the index of the first post to display on the current page
        // This calculates which post to start showing on the current page. 
        // For example, if you're on page 2 and show 10 posts per page, the first 
        // post to show on page 2 would be the 11th post overall.
        $this_page_first_result = ($page - 1) * $results_per_page;

        // Get only the posts needed for the current page
        $displayed_posts = array_slice($posts, $this_page_first_result, $results_per_page);

        foreach ($displayed_posts as $post) {
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
                    if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == $post['user_id'] || $_SESSION['username'] == 'admin')) {
                        // Display buttons only if user is logged in
                        ?>
                    <button type="button" class="btn btn-info" onclick="location.href='update_blogpost.php?id=<?php echo $post['id']; ?>'">Update Blog Post</button>
                    <button type="button" class="btn btn-secondary" onclick="location.href='delete_blogpost.php?id=<?php echo $post['id']; ?>'">Delete Blog Post</button>
                        <?php    
                    }

                    // Script to fetch comments from database
                    include_once 'get_comments.php';

                    // Display comments for this post
                    $comments = getComments($pdo, $post['id']);
                    echo "<div class='comments'>";
                    foreach ($comments as $comment) {
                        echo "<div class='comment'>";
                        echo "<p><strong>" . htmlspecialchars($comment['author']) . "</strong> (" . htmlspecialchars($comment['created_at']) . ")</p>";
                        echo "<p>" . htmlspecialchars($comment['content']) . "</p>";
                        echo "</div>";
                    }
                    echo "</div>";
                    ?>
                    <!-- Comment Button -->
                    <a class="comment-button">Comment</a>

                    <form method="post" action="submit_comment.php" class="mt-3 comment-form" style="display: none;">
                        <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">

                        <div class="form-group">
                            <input type="text" name="author" placeholder="Your name" class="form-control">
                        </div>

                        <div class="form-group">
                            <textarea name="content" placeholder="Your comment" class="form-control"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Post comment</button>
                    </form>
                </div>
            </div>
            <?php
        }
        ?>
        <?php
        // Pagination links
        for ($page = 1; $page <= $number_of_pages; $page++) {
            echo '<a href="?page=' . $page . '">' . $page . '</a> ';
        }
        ?>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            // Toggle the display of the comment form related to each comment button
            $('.comment-button').click(function() {
                $(this).next('.comment-form').toggle(); // Selects the next sibling element with class 'comment-form'
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
