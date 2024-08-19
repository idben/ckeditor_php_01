<?php
if ($_FILES['upload']) {
  $target_dir = "uploads/";
  
  // 取得原始檔案的副檔名
  $imageFileType = strtolower(pathinfo($_FILES["upload"]["name"], PATHINFO_EXTENSION));

  // 生成新的檔名：時間戳記 + 副檔名
  $newFileName = time() . '.' . $imageFileType;
  $target_file = $target_dir . $newFileName;

  $uploadOk = 1;

  // 檢查是否為圖片
  $check = getimagesize($_FILES["upload"]["tmp_name"]);
  if ($check !== false) {
    $uploadOk = 1;
  } else {
    $uploadOk = 0;
    echo json_encode(['error' => '指定的檔案不是圖片']);
    exit();
  }

  // 檢查檔案大小 (例如：1000KB)
  if ($_FILES["upload"]["size"] > 1000000) {
    $uploadOk = 0;
    echo json_encode(['error' => '檔案超過1000k']);
    exit();
  }

  // 允許的檔案格式
  $allowed = ['jpg', 'png', 'jpeg', 'gif'];
  if (!in_array($imageFileType, $allowed)) {
    $uploadOk = 0;
    echo json_encode(['error' => '只接受 JPG, JPEG, PNG 或 GIF 這幾種檔案格式']);
    exit();
  }

  // 檢查 $uploadOk 是否設定為 0
  if ($uploadOk == 0) {
    echo json_encode(['error' => '檔案沒有上傳']);
  } else {
    if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
      // 回傳圖片的 URL
      $url = $target_dir . $newFileName;
      echo json_encode(['url' => $url]);
    } else {
      echo json_encode(['error' => '上傳檔案發生錯誤']);
    }
  }
} else {
  echo json_encode(['error' => '沒有上傳檔案']);
}
?>