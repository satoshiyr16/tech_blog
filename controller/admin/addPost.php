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

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//   $title = $_POST['title'];
//   $content = $_POST['postContent'] ?? '';
//   $res = $post->insPostData($title, $content);
// }

$twig->addGlobal('CONTROLLER_ADMIN_DIR', autoload::CONTROLLER_ADMIN_DIR);
$twig->addGlobal('CSS_ADMIN_DIR', autoload::CSS_ADMIN_DIR);
$twig->addGlobal('JS_ADMIN_DIR', autoload::JS_ADMIN_DIR);
$twig->addGlobal('CSS_MODULE_DIR', autoload::CSS_MODULE_DIR);
$template = $twig->load('addPost.twig');
echo $template->render([]);


$users = [
  ['id' => 1, 'pref' => '北海道', 'name' => 'satou'],
  ['id' => 2, 'pref' => '東京', 'name' => 'tarou'],
  ['id' => 3, 'pref' => '神奈川', 'name' => 'kobayashi'],
  ['id' => 4, 'pref' => '東京', 'name' => 'saitou'],
  ['id' => 5, 'pref' => '神奈川', 'name' => 'yamada'],
  ['id' => 6, 'pref' => '千葉', 'name' => 'suzuki'],
  ['id' => 7, 'pref' => '東京', 'name' => 'morita'],
  ['id' => 8, 'pref' => '埼玉', 'name' => 'takemoto'],
  ['id' => 9, 'pref' => '北海道', 'name' => 'matsumoto'],
];

function prefUser(array $users, callable $count) {
  foreach ($users as $user) {
    $prefUser[$user['pref']][] = $user['name'];
  }
  $count($prefUser);
}

function prefUserCount(array $sum) {
  foreach($sum as $val) {
    if(count($val) > 2) {
      foreach($val as $value){
        echo $value;
      }
    }
  }
}
