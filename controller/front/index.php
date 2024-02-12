<?php

namespace controller\front;

require_once '/Applications/MAMP/htdocs/tech_blog/controller/app/autoload.class.php';

use controller\app\autoload;

$loader = new \Twig_Loader_Filesystem(autoload::TWIG_DIR);
$twig = new \Twig_Environment($loader, [
  'cache' => autoload::CACHE_DIR
]);

$twig->addGlobal('JS_FRONT_DIR', autoload::JS_FRONT_DIR);
$twig->addGlobal('CSS_FRONT_DIR', autoload::CSS_FRONT_DIR);
$template = $twig->load('index.html.twig');
echo $template->render([]);
