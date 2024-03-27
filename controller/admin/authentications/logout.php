<?php

namespace controller\admin\authentication;

require_once '/Applications/MAMP/htdocs/tech_blog/controller/app/autoload.class.php';

use controller\app\autoload;

session_start();

$_SESSION = array();

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

session_destroy();

header('Location: http://localhost:8888/tech_blog/controller/admin/authentications/login.php');
exit();
