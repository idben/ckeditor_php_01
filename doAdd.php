<?php
require_once("./PDO_connect.php");
$result = [];
// 取得標題和內容
$title = $_POST['title'];
$content = $_POST['content'];

try {
  // 準備 SQL 語句，使用 ? 作為佔位符
  $sql = "INSERT INTO article (title, content) VALUES (?, ?)";
  $stmt = $pdo->prepare($sql);

  // 綁定參數並執行語句
  if ($stmt->execute([$title, $content])) {
    $result["status"] = "success";
    $result["message"] = "文章已成功保存到資料庫中。";
    echo json_encode($result);
  } else {
    $result["status"] = "fail";
    $result["message"] = "儲存文章時發生錯誤。";
    echo json_encode($result);
  }
} catch (PDOException $e) {
  $result["status"] = "error";
  $result["message"] = "資料庫連接失敗: " . $e->getMessage();
  echo json_encode($result);
}
?>