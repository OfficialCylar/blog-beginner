<?php

require_once __DIR__ . "/DB.php";


class Interaction extends DB 
{

    public function PostComment(int $blogId, string $input)
    {
        $prepare = $this->db->prepare('INSERT INTO comments (blog_id, username, content) VALUES (:blog_id, :username, :content)');
        $prepare->bindParam(":username", $this->username);
        $prepare->bindParam(":content", $input);
        $prepare->bindParam(":blog_id", $blogId, PDO::PARAM_INT);
        if($prepare->execute()) 
        {
            return self::SUCCESS;
        }
        else
        {
            return self::ERROR;
        }
    }

    public function FetchComments(int $blogId) 
    {
        $prepare = $this->db->prepare('SELECT username, content FROM comments WHERE blog_id = :blog_id');
        $prepare->bindParam(":blog_id", $blogId, PDO::PARAM_INT);
        $prepare->execute();
        return $prepare->fetchAll(PDO::FETCH_ASSOC);
    }

    public function DebugOutput(array $content) 
    {
        echo '<pre>';
        var_dump($content);
        echo '</pre>';
    }
}



?>