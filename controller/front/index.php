<?php

namespace controller\front;

require_once '/Applications/MAMP/htdocs/tech_blog/controller/app/autoload.class.php';

use controller\app\autoload;
use model\dbCommand;
use model\entities\post;

$db = new dbCommand(autoload::DB_HOST, autoload::DB_USER, autoload::DB_PASS, autoload::DB_NAME);
$post = new post($db);

$loader = new \Twig_Loader_Filesystem(autoload::TWIG_FRONT_DIR);
$twig = new \Twig_Environment($loader, [
  'cache' => autoload::CACHE_DIR
]);

$title = $db->select('post', 'title', '', ['post_id = ?'], [1]);

$twig->addGlobal('JS_FRONT_DIR', autoload::JS_FRONT_DIR);
$twig->addGlobal('CSS_FRONT_DIR', autoload::CSS_FRONT_DIR);
$template = $twig->load('index.html.twig');
echo $template->render(['title' => $title]);
