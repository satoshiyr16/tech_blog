<?php

namespace controller\admin;

require_once '/Applications/MAMP/htdocs/tech_blog/controller/app/autoload.class.php';

use controller\app\autoload;
use model\dbCommand;
use model\entities\post;

$db = new dbCommand(autoload::DB_HOST, autoload::DB_USER, autoload::DB_PASS, autoload::DB_NAME);
$post = new post($db);

$loader = new \Twig_Loader_Filesystem(autoload::TWIG_ADMIN_DIR);
$twig = new \Twig_Environment($loader, [
  'cache' => autoload::CACHE_DIR
]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = 'あ';
  $content = $_POST['postContent'] ?? '';
  $res = $post->insPostData($title, $content);
}


$twig->addGlobal('CONTROLLER_ADMIN_DIR', autoload::CONTROLLER_ADMIN_DIR);
$twig->addGlobal('CSS_ADMIN_DIR', autoload::CSS_ADMIN_DIR);
$template = $twig->load('addPost.html.twig');
echo $template->render([]);
