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

$rec_posts = $post->getRecommendedPosts();
$new_posts = $post->newPostLimit10();
$tag_posts = $post->getPostsByTagId(25);

$twig->addGlobal('JS_FRONT_DIR', autoload::JS_FRONT_DIR);
$twig->addGlobal('CSS_FRONT_DIR', autoload::CSS_FRONT_DIR);
$twig->addGlobal('IMAGE_DIR', autoload::IMAGE_DIR);
$twig->addGlobal('CSS_MODULE_DIR', autoload::CSS_MODULE_DIR);
$twig->addGlobal('APP_URL', autoload::APP_URL);
$template = $twig->load('index.twig');
echo $template->render(['new_posts' => $new_posts, 'rec_posts' => $rec_posts, 'tag_posts' => $tag_posts]);
