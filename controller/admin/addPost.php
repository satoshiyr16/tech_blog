<?php

namespace controller\admin;

require_once '/Applications/MAMP/htdocs/tech_blog/controller/app/autoload.class.php';

use controller\app\autoload;
use model\dbCommand;
use model\entities\post;
use model\entities\tag;

$db = new dbCommand(autoload::DB_HOST, autoload::DB_USER, autoload::DB_PASS, autoload::DB_NAME);
$post = new post($db);
$tag = new tag($db);

$loader = new \Twig_Loader_Filesystem(autoload::TWIG_ADMIN_DIR);
$twig = new \Twig_Environment($loader, [
  'cache' => autoload::CACHE_DIR
]);

session_start();
if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
  $userName = $_SESSION['username'];

  if (isset($_POST['send']) === true) {
    $title = $_POST['title'];
    $content = $_POST['postContent'] ?? '';
    $tagNames = isset($_POST['tags']) && trim($_POST['tags']) !== '' ? explode(',', $_POST['tags']) : null;

    $postId = $post->insPostData($title, $content);

    if (isset($tagNames)) {
      if ($postId) {
        foreach ($tagNames as $tagName) {
          $tagId = $tag->insertTag(trim($tagName));
          if ($tagId) {
            $tag->linkPostAndTag($postId, $tagId);
          }
        }
      }
    }

    header('Location: http://localhost:8888/tech_blog/controller/admin/addPost.php');
    exit;
  }
} else {
  header('Location: http://localhost:8888/tech_blog/controller/admin/authentications/login.php');
  exit();
}

$twig->addGlobal('APP_URL', autoload::APP_URL);
$twig->addGlobal('CONTROLLER_ADMIN_DIR', autoload::CONTROLLER_ADMIN_DIR);
$twig->addGlobal('CSS_ADMIN_DIR', autoload::CSS_ADMIN_DIR);
$twig->addGlobal('JS_ADMIN_DIR', autoload::JS_ADMIN_DIR);
$twig->addGlobal('CSS_MODULE_DIR', autoload::CSS_MODULE_DIR);
$template = $twig->load('addPost.twig');
echo $template->render(['userName' => $userName]);
