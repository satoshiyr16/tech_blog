<?php

namespace controller\app;

date_default_timezone_set('Asia/Tokyo');

require_once __DIR__ . '/../../vendor/autoload.php';

class autoload
{

  const APP_DIR = '/Applications/MAMP/htdocs/tech_blog/';
  const CONTROLLER_DIR = self::APP_DIR . 'controller/app';
  const TWIG_DIR = self::APP_DIR . 'view/twig/front/';
  const JS_FRONT_DIR = self::APP_URL . 'view/js/front';
  const CSS_FRONT_DIR = self::APP_URL . 'view/css/front';
  const CACHE_DIR = false;
  const APP_URL = 'http://localhost:8888/tech_Blog/';
  // const ENTRY_URL = self::APP_URL . 'shopping/';

  public static function loadClass($class)
  {
    $path = str_replace('\\', '/', self::CONTROLLER_DIR . $class . '.class.php');
    require_once $path;
  }
}

spl_autoload_register(['controller\app\autoload', 'loadClass']);
