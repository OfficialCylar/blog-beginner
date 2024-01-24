
<?php


session_start(); 

require_once __DIR__ . "/classes/DB.php";

if(!isset($_SESSION["loggedin"])) {
    header("Location: login.php");
    exit;
} 



$PostedBlogs = [];
$conn = new DB($_SESSION['username'], '');
$PostedBlogs = $conn->FetchBlogs();

$loggedIn = 'Welcome in : ' . $_SESSION['username'] . '<br>'; 

if($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $title = htmlspecialchars($_POST['title']);
    $text = htmlspecialchars($_POST['text']);
     
    $result = $conn->SubmitBlog($title, $text);
    if($result == DB::SUCCESS)
    {
        echo 'Blog posted!' . '<br>'; 
    }
    else
    {
        echo DB::ERROR . '<br>'; 
    }

    $PostedBlogs = $conn->FetchBlogs();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Possibily add if im logged in here instead to display different navigations -->
    <?php include("includes/nav.php"); ?>
    
    <main>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="title">Title:</label><br>
            <input type="text" name="title" id="title" required><br>

            <label for="text">Blog Post:</label><br>
            <textarea name="text" id="text" rows="4" cols="50" required></textarea><br>

            <input type="submit" value="Submit">
        </form>
    </main>
<?php include("includes/footer.php"); ?>
</body>
</html>