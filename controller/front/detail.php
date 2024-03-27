<?php

namespace controller\front;

require_once '/Applications/MAMP/htdocs/tech_blog/controller/app/autoload.class.php';

use controller\app\autoload;
use model\dbCommand;

$db = new dbCommand(autoload::DB_HOST, autoload::DB_USER, autoload::DB_PASS, autoload::DB_NAME);

$loader = new \Twig_Loader_Filesystem(autoload::TWIG_FRONT_DIR);
$twig = new \Twig_Environment($loader, [
  'cache' => autoload::CACHE_DIR
]);

$post_id = isset($_GET['post_id']) ? (int) $_GET['post_id'] : 0;

$postData = $db->select('posts', '*', 'post_id = ?', [$post_id], '', '');

if (!empty($postData)) {
  $post = $postData[0];
} else {
  $post = null;
}
$twig->addGlobal('JS_FRONT_DIR', autoload::JS_FRONT_DIR);
$twig->addGlobal('CSS_FRONT_DIR', autoload::CSS_FRONT_DIR);
$twig->addGlobal('IMAGE_DIR', autoload::IMAGE_DIR);
$twig->addGlobal('CSS_MODULE_DIR', autoload::CSS_MODULE_DIR);
$twig->addGlobal('APP_URL', autoload::APP_URL);
$template = $twig->load('detail.twig');
echo $template->render(['post' => $post]);
