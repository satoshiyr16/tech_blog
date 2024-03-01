<?php

namespace model\entities;

class post
{
  private $db = null;

  public function __construct($db = null)
  {
    $this->db = $db;
  }

  public function insPostData($title, $content)
  {
    $table = 'post';
    $insData = [
      'title' => $title,
      'content' => $content
    ];

    return $this->db->insert($table, $insData);
  }

}
?>
