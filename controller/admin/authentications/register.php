<?php

namespace controller\admin\authentication;

require_once '/Applications/MAMP/htdocs/tech_blog/controller/app/autoload.class.php';

use controller\app\autoload;
use model\dbCommand;
use model\entities\authentications\user;

$db = new dbCommand(autoload::DB_HOST, autoload::DB_USER, autoload::DB_PASS, autoload::DB_NAME);
$user = new user($db);

$loader = new \Twig_Loader_Filesystem(autoload::TWIG_ADMIN_DIR);
$twig = new \Twig_Environment($loader, [
  'cache' => autoload::CACHE_DIR
]);

if (isset($_POST['register']) === true) {
  $userName = $_POST['userName'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $userId = $user->insUserData($userName, $email, $password);

  header('Location: http://localhost:8888/tech_blog/controller/admin/authentications/login.php');
  exit;
}

$twig->addGlobal('APP_URL', autoload::APP_URL);
$twig->addGlobal('CONTROLLER_ADMIN_DIR', autoload::CONTROLLER_ADMIN_DIR);
$twig->addGlobal('CSS_ADMIN_DIR', autoload::CSS_ADMIN_DIR);
$twig->addGlobal('JS_ADMIN_DIR', autoload::JS_ADMIN_DIR);
$twig->addGlobal('CSS_MODULE_DIR', autoload::CSS_MODULE_DIR);
$template = $twig->load('authentications/register.twig');
echo $template->render([]);
