<?php
require("db.php");
DEFINE('DATABASE_USER', $username);
DEFINE('DATABASE_PASSWORD', $password);
DEFINE('DATABASE_HOST', 'localhost');
DEFINE('DATABASE_NAME', $dbname);

class PostAPI
{
    public $db;
    public function __construct()
    {
        $this->db=new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
        $this->db->set_charset("utf8");
        $this->db->autocommit(FALSE);
        if ($this->db->connect_errno > 0) {
            die('Unable to connect to database [' . $this->db->connect_error . ']');
        }
        
        
    }
    
    public function __destruct()
    {
        $this->db->close();
    }
    
    function addToDB($title, $content, $link, $date, $source, $town, $lat, $lng, $img_link)
    {
        $stmt = $this->db->prepare("INSERT INTO feed(title, content, link,date,source,town,lat,lng,img_link) VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('sssssssss', $title, $content, $link, $date, $source, $town, $lat, $lng, $img_link);
        $stmt->execute();
        $stmt->close();
        return true;
    }
    
}
?>