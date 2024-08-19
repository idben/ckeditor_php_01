<?php
require_once("./PDO_connect.php");
try {
  if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];

    // 準備 SQL 語句來根據 id 讀取文章
    $sql = "SELECT * FROM article WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    // 取得文章資料
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($article) {
    } else {
      die("找不到這篇文章。");
    }
  } else {
    die("無效的文章 ID。");
  }

} catch (PDOException $e) {
  die("資料庫連接失敗: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="zh-TW">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>修改</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
  <style>
    .ck-editor__editable_inline {
      min-height: 400px !important;
      height: 400px !important;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>CKEditor 5 + php upload 範例</h1>
    <div class="input-group mb-1">
      <div class="input-group-text">標題</div>
      <input type="text" name="title" class="form-control" value="<?=$article["title"]?>">
    </div>
    <div id="editor">
      <?=$article['content']?>
    </div>
    <div class="d-flex mt-1">
      <div class="btn btn-sm btn-primary ms-auto btn-send me-1">送出</div>
      <a class="btn btn-sm btn-primary" href="./index.php">返回</a>
    </div>
  </div>

  <script>
    let editorInstance;
    const btnSend = document.querySelector(".btn-send");
    const saveURL = "./doAdd.php";
    const inputTitle = document.querySelector("[name=title]")

    // btnSend.addEventListener("click", e => {
    //   const formData = new FormData();
    //   formData.append("title", inputTitle.value);
    //   formData.append("content", editorInstance.getData());

    //   fetch(saveURL, {
    //     method: "POST",
    //     body: formData
    //   }).then(res=>res.json()).then(result=>{
    //     console.log(result);
    //     if(result.status === "success"){
    //       window.location.href = "./index.php";
    //     }else{
    //       throw new Error(result.message);
    //     }
    //   }).catch(error => {
    //     console.log(error);
    //     alert(error.message)
    //   });
      
      
    // })

    class MyUploadAdapter {
      constructor(loader) {
        this.loader = loader;
      }

      upload() {
        return this.loader.file
          .then(file => new Promise((resolve, reject) => {
            const data = new FormData();
            data.append('upload', file);

            fetch('upload.php', {
              method: 'POST',
              body: data
            })
              .then(response => response.json())
              .then(data => {
                resolve({
                  default: data.url
                });
              })
              .catch(err => {
                reject(err);
              });
          }));
      }

      abort() {
        // If the user aborts the upload, this method is called.
      }
    }

    function MyCustomUploadAdapterPlugin(editor) {
      editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
        return new MyUploadAdapter(loader);
      };
    }

    ClassicEditor
      .create(document.querySelector('#editor'), {
        extraPlugins: [MyCustomUploadAdapterPlugin]
      })
      .then(editor => {
        editorInstance = editor;
      })
      .catch(error => {
        console.error(error);
      });

  </script>
</body>

</html>