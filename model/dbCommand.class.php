<?php

namespace model;

class dbCommand
{
  public $db_con = null;
  public $db_host = '';
  public $db_user = '';
  public $db_pass = '';
  public $db_name = '';
  private $order = '';
  private $limit = '';
  private $offset = '';
  private $groupby = '';

  public function __construct($db_host, $db_user, $db_pass, $db_name)
  {
    $this->db_con = $this->connectDB($db_host, $db_user, $db_pass, $db_name);
    $this->db_host = $db_host;
    $this->db_user = $db_user;
    $this->db_pass = $db_pass;
    $this->db_name = $db_name;
    $this->order = '';
    $this->limit = '';
    $this->offset = '';
    $this->groupby = '';
  }

  private function connectDB($db_host, $db_user, $db_pass, $db_name)
  {
    $tmp_con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if ($tmp_con !== false) {
      error_log("Database connection established to $db_name.", 0);
      return $tmp_con;
    } else {
      $error_msg = "Connect failed: " . mysqli_connect_error();
      error_log($error_msg, 0);
      exit($error_msg);
    }
  }

  public function insert($table, $insData = [])
  {
    $insDataKey = array_keys($insData);
    $insDataVal = array_values($insData);
    $placeHolders = array_fill(0, count($insData), '?');

    // 文字列にする "title, content, tag_id"
    $columns = implode(", ", $insDataKey);
    // "?, ?, ?, "
    $preSt = implode(", ", $placeHolders);

    $sql = "INSERT INTO $table ($columns) VALUES ($preSt)";

    // 自動的にエスケープ
    $stmt = $this->db_con->prepare($sql);
    if (!$stmt) {
      error_log("Prepare failed: " . $this->db_con->error);
      return false;
    }

    // バインドする値のタイプを準備 ('s' = string, 'i' = integer, 'd' = double, 'b' = blob)
    $types = str_repeat('s', count($insDataVal)); // この例では全ての値を文字列として扱います

    // bind_param() に渡すためのパラメータ配列を準備
    $params = array_merge(array($types), $insDataVal);
    foreach ($params as $key => $value) {
      $params[$key] = &$params[$key]; // 参照渡し
    }

    // パラメータをバインドし、SQLを実行
    call_user_func_array(array($stmt, 'bind_param'), $params);

    $res = $stmt->execute();
    if (!$res) {
      error_log("Execute failed: " . $stmt->error);
    }

    $stmt->close();

    return $res;
  }

  private function catchError($errArr = [])
  {
    // errorMessageが2番目に格納されている
    $errMsg = (!empty($errArr[2])) ? $errArr[2] : "";
    // exitと同じ
    die("SQLエラーが発生しました。" . $errArr[2]);
  }


  public function select($table, $column = '', $where = '', $arrVal = [], $orderby = '')
  {
      $sql = $this->getSql('select', $table, $where, $column, $orderby);
      // mysqli prepare statement
      $stmt = $this->db_con->prepare($sql);

      // パラメータがある場合はバインドします。
      if (!empty($arrVal)) {
        $types = ''; // パラメータの型を格納する文字列を初期化
        foreach ($arrVal as $param) {
            // パラメータの型に応じて型指定子を追加
            if (is_float($param)) {
                $types .= 'd'; // double
            } elseif (is_int($param)) {
                $types .= 'i'; // integer
            } else {
                $types .= 's'; // string
            }
        }

        // bind_paramの引数を準備（型指定子とパラメータの値）
        $bindParams = [];
        $bindParams[] = &$types; // 参照渡しで型指定子を最初に追加
        foreach ($arrVal as $key => &$param) {
            $bindParams[] = &$param; // 各パラメータの参照を追加
        }

        // bind_paramを呼び出し
        call_user_func_array([$stmt, 'bind_param'], $bindParams);
    }

      // SQLを実行
      $stmt->execute();
      // 結果を取得
      $result = $stmt->get_result();

      $data = [];
      while ($row = $result->fetch_assoc()) {
          $data[] = $row;
      }

      // ステートメントを閉じる
      $stmt->close();

      return $data;
  }


  private function getSql($type, $table, $where = '', $column = '', $orderby = '')
  {
    switch($type) {
      case 'select':
        $columnKey = ($column !== '') ? $column : "*";
      break;

      case 'count':
        $columnKey = 'COUNT(*) AS NUM';
      break;

      default:
      break;
    }

    $whereSQL = ($where !== '') ? ' WHERE ' . $where : '';
    $orderbySQL = ($orderby !== '') ? ' ORDER BY ' . $orderby : '';
    $sql = " SELECT " . $columnKey . " FROM " . $table . $whereSQL . $orderbySQL;

    return $sql;
  }
}
