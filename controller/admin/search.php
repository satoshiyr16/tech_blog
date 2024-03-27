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

$allTags = $tag->getTagsLimit25();
$results = '';

session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
  $userName = $_SESSION['username'];
  if (isset($_GET['search'])) {
    $keyword = (isset($_GET['keyword']) && !empty($_GET['keyword'])) ? $_GET['keyword'] : [];
    $tags = (isset($_GET['tags']) && !empty($_GET['tags'])) ? $_GET['tags'] : [];
    $results = $post->searchPosts($keyword, $tags);
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
$twig->addGlobal('IMAGE_DIR', autoload::IMAGE_DIR);
$template = $twig->load('search.twig');
echo $template->render(['userName' => $userName, 'allTags' => $allTags, 'results' => $results]);
