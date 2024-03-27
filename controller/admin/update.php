<?php

namespace controller\admin;

require_once '/Applications/MAMP/htdocs/tech_blog/controller/app/autoload.class.php';

use controller\app\autoload;
use model\dbCommand;
use model\entities\post;


$db = new dbCommand(autoload::DB_HOST, autoload::DB_USER, autoload::DB_PASS, autoload::DB_NAME);
$post = new post($db);

session_start();
if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
  $userName = $_SESSION['username'];
  if (isset($_POST['update'])) {
    $postId = $_POST['postId'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $data = [
      'title' => $title,
      'content' => $content
    ];

    $where = ['post_id' => $postId];

    $result = $post->updatePost($data,$where);

    if($result) {
      header('Location: http://localhost:8888/tech_blog/controller/admin/index.php');
  exit();
    }
  }
} else {
  header('Location: http://localhost:8888/tech_blog/controller/admin/authentications/login.php');
  exit();
}
