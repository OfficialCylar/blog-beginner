<?php

session_start(); 

require_once __DIR__ . "/classes/DB.php";
require_once __DIR__ . "/classes/Interaction.php";

$conn = new Interaction($_SESSION['username'], '');
$PostedBlogs = $conn->FetchBlogs();
if($_SERVER["REQUEST_METHOD"] == 'POST') 
{
    $blogId = $_POST['blog_id'];
    $content = htmlspecialchars($_POST['reply_content']);
    $result = $conn->PostComment($blogId, $content);
    if($result == DB::SUCCESS) 
    {
        echo 'Comment posted';
        header("Location: posts.php");
    }
    else 
    {
        echo 'Comment failed';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include("includes/nav.php"); ?>
 
    <main>
        <h2 class="title">Blog Posts</h2>
        <div class="blog-container">
            <!-- Might change to 3 depends -->
                <?php foreach ($PostedBlogs as $key => $blog) : ?>
                    <?php if ($key >= 4) break; ?>
                    <div class="blog-post">
                        <h3><?= htmlspecialchars($blog['title']) ?></h3>
                        <p><?= htmlspecialchars($blog['content']) ?></p>

                        <div class="comments-container">
                            <h4>Comments</h4>
                            <?php
                             
                            if (isset($blog['id'])) {
                                echo "Found blog id";
                                $comments = $conn->FetchComments($blog['id']);  
            
                                foreach ($comments as $comment) {
                                    echo "<div class='comment'>" . htmlspecialchars($comment['content']) . "</div>";
                                }
                            } else {
                                echo "Couldn't find";
                                echo "Invalid blog entry.";
                            }
                            ?>
                        </div>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <?php
                             
                            if (isset($blog['id'])) {
                                echo '<input type="hidden" name="blog_id" value="' . $blog['id'] . '">';
                            }
                            ?>
                            <textarea name="reply_content"></textarea>
                            <input type="submit" value="Submit Reply">
                            <input type="hidden" name="blog_id" value="<?= $blog['id'] ?>">
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
     </main>


     <?php include("includes/footer.php"); ?>

</body>
</html>