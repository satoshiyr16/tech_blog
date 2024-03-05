<?php

namespace controller\app;

date_default_timezone_set('Asia/Tokyo');

require_once __DIR__ . '/../../vendor/autoload.php';

class autoload
{
  const DB_HOST = 'localhost';
  const DB_USER = 'root';
  const DB_PASS = 'root';
  const DB_NAME = 'tech_blog';

  const APP_URL = 'http://localhost:8888/tech_blog/';
  const APP_DIR = '/Applications/MAMP/htdocs/tech_blog/';
  const CONTROLLER_APP_DIR = self::APP_DIR . 'controller/app/';
  const CONTROLLER_ADMIN_DIR = self::APP_URL . 'controller/admin/';
  const CONTROLLER_FRONT_DIR = self::APP_URL . 'controller/front/';
  const TWIG_FRONT_DIR = self::APP_DIR . 'view/twig/front/';
  const TWIG_ADMIN_DIR = self::APP_DIR . 'view/twig/admin/';
  const JS_FRONT_DIR = self::APP_URL . 'view/js/front/';
  const CSS_FRONT_DIR = self::APP_URL . 'view/css/front/';
  const JS_ADMIN_DIR = self::APP_URL . 'view/js/admin/';
  const CSS_ADMIN_DIR = self::APP_URL . 'view/css/admin/';
  const CSS_MODULE_DIR = self::APP_URL . 'view/css/';
  const IMAGE_DIR = self::APP_URL . 'view/images/';
  const CACHE_DIR = false;
  // const ENTRY_URL = self::APP_URL . 'shopping/';

  public static function loadClass($class)
  {
    $path = str_replace('\\', '/', self::APP_DIR . $class . '.class.php');
    require_once $path;
  }
}

spl_autoload_register(['controller\app\autoload', 'loadClass']);
