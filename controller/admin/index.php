<?php

namespace controller\admin;

require_once '/Applications/MAMP/htdocs/tech_blog/controller/app/autoload.class.php';

use controller\app\autoload;
use model\dbCommand;

$db = new dbCommand(autoload::DB_HOST, autoload::DB_USER, autoload::DB_PASS, autoload::DB_NAME);

$loader = new \Twig_Loader_Filesystem(autoload::TWIG_ADMIN_DIR);
$twig = new \Twig_Environment($loader, [
  'cache' => autoload::CACHE_DIR
]);

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//   $title = $_POST['title'];
//   $content = $_POST['postContent'] ?? '';
//   $res = $post->insPostData($title, $content);
// }

$twig->addGlobal('APP_URL', autoload::APP_URL);
$twig->addGlobal('CONTROLLER_ADMIN_DIR', autoload::CONTROLLER_ADMIN_DIR);
$twig->addGlobal('CSS_ADMIN_DIR', autoload::CSS_ADMIN_DIR);
$twig->addGlobal('JS_ADMIN_DIR', autoload::JS_ADMIN_DIR);
$twig->addGlobal('CSS_MODULE_DIR', autoload::CSS_MODULE_DIR);
$template = $twig->load('index.twig');
echo $template->render([]);
