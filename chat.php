
<?php


session_start(); 

require_once __DIR__ . "/classes/DB.php";

if(!isset($_SESSION["loggedin"])) {
    header("Location: login.php");
    exit;
} 

$PostedMessages = [];
$conn = new DB($_SESSION['username'], '');
$PostedMessages = $conn->FetchMessages();

$loggedIn = 'Welcome in : ' . $_SESSION['username'] . '<br>'; 

if($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $text = htmlspecialchars($_POST['text']);
    $result = $conn->Submit($text);

    if($result == DB::SUCCESS) 
    {
        $msg = 'Post submitted!!' . '<br>';
    }

    else 
    {
        $msg =  DB::ERROR . '<br>';
    }

    $PostedMessages = $conn->FetchMessages();
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
    <div class="message-container-box">
        <div class="message-logo">
            <h2 class="title">Chat Room</h2>
        </div>
        
        <div class="message-container">
            <ul class="message-list">
                <?php foreach ($PostedMessages as $messages) : ?>
                    <li>
                        <div class="message-item">
                            <img src="photos/cover.jpg" alt="Avatar">
                            <div class="message-content">
                                <strong><?= $messages['username'] ?>:</strong>
                                <?= $messages['post_text'] ?>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="form-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="message-form">
            <label for="text">Message:</label>
            <input type="text" name="text" id="text" placeholder="Enter a message to send ..." required>
            <input type="submit" value="Submit" class="submit-button">
        </form>
        </div>
   </div>
    
</main>


<?php include("includes/footer.php"); ?>
</body>
</html>