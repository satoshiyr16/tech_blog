<?php

namespace model\entities\authentications;

use model\dbCommand;

class user extends dbCommand
{
  private $db = null;

  public function __construct($db = null)
  {
    $this->db = $db;
  }

  public function insUserData($userName, $email, $password)
  {
    var_dump($userName);
    $table = 'users';
    $insData = [
      'userName' => $userName,
      'email' => $email,
      'password' => $password,
    ];

    return $this->db->insert($table, $insData);
  }

  public function getUser($email) {
    $user = $this->db->select('users', '*', 'email = ?', [$email], '');
    return $user;
  }

}
