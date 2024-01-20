<?php



class DB 
{
    private PDO $db;
    public string $username;
    public string $password;
    
    public const SUCCESS = "SUCCESSFULLY CREATED ACCOUNT";
    public const ERROR = "ERROR CREATING ACCOUNT";

    public const SUCCESSLOGIN = "SUCCESSFULLY LOGGED IN";
    public const ERRORLOGIN = "FAILED TO LOGIN";

    public function __construct(string $username, string $password) 
    {
        $this->username = $username;
        // Possible to hash password
        $this->password = $password;
        // Hardcoding because yeah.
        $this->db = new PDO("mysql:host=localhost;dbname=blog;", "root", "");
    }
    public function Signup()
    {
        $prepare = $this->db->prepare("INSERT INTO accounts (username, password) VALUES (:username, :password)");
        $prepare->bindParam(":username", $this->username);
        $prepare->bindParam(":password", $this->password);
        if($prepare->Execute()) {
            return self::SUCCESS;
        }
        else 
        {
            return self::ERROR;
        }
    }
    public function Signin() 
    {
        $prepare = $this->db->prepare("SELECT * FROM accounts WHERE username = :username AND password = :password");
        $prepare->bindParam(":username", $this->username);
        $prepare->bindParam(":password", $this->password);
        $prepare->execute();
        if($prepare->rowCount() > 0) 
        {
            $_SESSION['loggedin'] = true;
            $_SESSION['session_id'] = uniqid();
            $_SESSION['username'] = $this->username;
            header("Location: index.php");
            return self::SUCCESSLOGIN;
        }
        else
        {
            return self::ERRORLOGIN;
        }
    }
    public function Submit(string $string)
    {
        $prepare = $this->db->prepare('INSERT INTO posts(username, post_text) VALUES (:username, :post_text)');
        $prepare->bindParam(":username", $this->username);
        $prepare->bindParam(":post_text", $string);
         
        if($prepare->execute()) 
        {
            return self::SUCCESS;
        }
        else
        {
            return self::ERROR;
        }
    }
    public function FetchMessages()
    {
        $stmt = $this->db->query("SELECT username, post_text FROM posts");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }
    public function SubmitBlog(string $title, string $text) 
    {
        $prepare = $this->db->prepare('INSERT INTO blogs(title, content, username) VALUES (:title, :content, :username)');
        $prepare->bindParam(":title", $title);
        $prepare->bindParam(":content", $text);
        $prepare->bindParam(":username", $this->username);
        if($prepare->execute())
        {
            return self::SUCCESS;
        }
        else
        {
            return self::ERROR;
        }
    }
    
    public function FetchBlogs()
    {
        $collect = $this->db->query("SELECT title, content FROM blogs");
        return $collect->fetchAll(PDO::FETCH_ASSOC);
    }
}


?>