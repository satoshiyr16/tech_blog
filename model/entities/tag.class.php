<?php

namespace model\entities;

use model\dbCommand;

class tag extends dbCommand
{
  private $db = null;

  public function __construct($db = null)
  {
    $this->db = $db;
  }

  public function insertTag($tagName)
  {
    $insData = ['tag_name' => $tagName];
    return $this->db->insert('tags', $insData);
  }

  public function linkPostAndTag($postId, $tagId)
  {
    $insData = [
      'post_id' => $postId,
      'tag_id' => $tagId
    ];
    return $this->db->insert('posts_tags', $insData);
  }

  public function getTagsLimit25()
  {
    $tags = $this->db->select('tags', '*', '', [], '', '25');
    return $tags;
  }
}
