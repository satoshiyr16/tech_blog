<?php

namespace model\entities;

use model\dbCommand;

class post extends dbCommand
{
  private $db = null;

  public function __construct($db = null)
  {
    $this->db = $db;
  }

  public function getSelectedPost($postId)
  {
    $post = $this->db->select('posts', '*', 'post_id = ? AND deleted = ?', [$postId, 0], '');
    return $post;
  }

  public function getAllPosts()
  {
    $post = $this->db->select('posts', '*', 'deleted = ?', [0], 'updated_at DESC');
    return $post;
  }

  public function insPostData($title, $content)
  {
    $table = 'posts';
    $insData = [
      'title' => $title,
      'content' => $content,
    ];

    return $this->db->insert($table, $insData);
  }

  public function updatePost($data, $where)
  {
    $result = $this->db->update('posts', $data, $where);
    return $result;
  }

  public function getRecommendedPosts()
  {
    $rec_posts = $this->db->select('posts', '*', 'recommended_flg = ? AND deleted = ?', [1, 0], 'created_at DESC');
    return $rec_posts;
  }

  public function newPostLimit10()
  {
    $new_posts = $this->db->select('posts', '*', 'deleted = ?', [0], 'updated_at DESC', '10');
    return $new_posts;
  }

  public function getPostsByTagId($tagId)
  {
    $baseTable = "posts";
    $joinConditions = [
      [
        'joinTable' => 'posts_tags',
        'on' => 'posts.post_id = posts_tags.post_id'
      ],
      [
        'joinTable' => 'tags',
        'on' => 'posts_tags.tag_id = tags.tag_id'
      ]
    ];
    $columns = 'posts.*';
    $where = 'tags.tag_id = ? AND posts.deleted = 0';
    $params = [$tagId];
    $types = 'i';
    $orderby = 'posts.updated_at DESC';

    return $this->db->selectWithJoin($baseTable, $joinConditions, $columns, $where, $params, $types, $orderby);
  }

  public function searchPosts($keyword = '', $tagIds = [])
  {
    if ($keyword !== '' && $tagIds !== []) {
      return $this->searchPostsByKeywordAndTag($keyword, $tagIds);
    } elseif ($keyword !== '' && $tagIds === []) {
      return $this->searchPostsByKeyword($keyword);
    } elseif ($keyword === '' && $tagIds !== []) {
      return $this->searchPostsByTag($tagIds);
    } else {
      return false;
    }
  }

  public function searchPostsByKeyword($keyword)
  {
    $searchKeyword = '%' . $keyword . '%';
    $result = $this->db->select('posts', 'post_id, title, updated_at', '(title LIKE ? OR content LIKE ?) AND deleted = 0', [$searchKeyword, $searchKeyword], 'updated_at ASC', '');
    return $result;
  }

  public function searchPostsByTag($tagIds)
  {
    $joinConditions = [
      [
        'joinTable' => 'posts_tags',
        'on' => 'posts.post_id = posts_tags.post_id'
      ],
      [
        'joinTable' => 'tags',
        'on' => 'posts_tags.tag_id = tags.tag_id'
      ]
    ];

    $columns = 'posts.post_id, posts.title, posts.updated_at';
    $params = [];
    $types = '';
    $where = 'posts.deleted = 0';

    // タグID検索条件
    if (!empty($tagIds)) {
      $placeholders = implode(',', array_fill(0, count($tagIds), '?'));
      $where = " AND tags.tag_id IN ($placeholders)";
      foreach ($tagIds as $tagId) {
        $params[] = $tagId;
        $types .= 'i'; // タグIDは整数
      }
    } else {
      $where = "1=1"; // タグが指定されていない場合はすべての投稿を対象
    }

    $orderby = 'posts.updated_at DESC';

    return $this->db->selectWithJoin('posts', $joinConditions, $columns, $where, $params, $types, $orderby);
  }

  public function searchPostsByKeywordAndTag($keyword, $tagIds = [])
  {
    $joinConditions = [
      [
        'joinTable' => 'posts_tags',
        'on' => 'posts.post_id = posts_tags.post_id'
      ],
      [
        'joinTable' => 'tags',
        'on' => 'posts_tags.tag_id = tags.tag_id'
      ]
    ];

    $columns = 'posts.post_id, posts.title, posts.updated_at';
    $params = [];
    $whereParts = ['posts.deleted = 0'];
    $types = '';

    if (!empty($keyword)) {
      $whereParts[] = '(posts.title LIKE ? OR posts.content LIKE ?)';
      $params[] = "%$keyword%";
      $params[] = "%$keyword%";
      $types .= 'ss';
    }

    if (!empty($tagIds)) {
      $placeholders = implode(',', array_fill(0, count($tagIds), '?'));
      $whereParts[] = "tags.tag_id IN ($placeholders)";
      foreach ($tagIds as $tagId) {
        $params[] = $tagId;
        $types .= 'i';
      }
    }

    $where = implode(' AND ', $whereParts);
    $orderby = 'posts.updated_at DESC';

    return $this->db->selectWithJoin('posts', $joinConditions, $columns, $where, $params, $types, $orderby);
  }
}
