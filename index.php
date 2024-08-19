<?php
require_once("./PDO_connect.php");
try {
  $sql = "SELECT * FROM article";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "資料庫連接失敗: " . $e->getMessage();
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    .unit{
      .num{
        width: 80px;
      }
      .ctrl{
        width: 120px;
      }
    }
    .flex1{
      flex: 1;
    }
  </style>
  <title>文章列表</title>
</head>
<body>
  <div class="container mt-3">
    <h1>文章列表</h1>
    <div class="d-flex">
      <a href="./form.html" class="btn btn-primary btn-sm ms-auto">增加</a>
    </div>
    <div class="unit d-flex text-bg-dark p-1 my-1">
      <div class="num">#</div>
      <div class="title flex1">標題</div>
      <div class="ctrl text-end">控制</div>
    </div>
    <?php foreach ($articles as $index => $article): ?>
    <div class="unit d-flex mb-1">
      <div class="num"><?=$index+1?></div>
      <div class="title flex1"><?=$article["title"]?></div>
      <div class="ctrl text-end">
        <a href="doDelete.php?id=<?=$article["id"]?>" class="btn btn-danger btn-sm me-1">刪除</a>
        <a href="form.php?id=<?=$article["id"]?>" class="btn btn-primary btn-sm">修改</a>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</body>
</html>