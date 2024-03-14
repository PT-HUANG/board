<?php 
  session_start();
  require_once("./conn.php");
  require_once("./utils.php");
  if (isset($_GET['err_code']) && $_GET['err_code'] === '1') {
    echo "<script>alert('資料不齊全')</script>";
  }
  
  $username = NULL;
  if(!empty($_SESSION['username'])){
    $username = $_SESSION['username'];
    $user = getUserFromUsername($username);
    $nickname = $user['nickname'];
  }

  if(!empty($_GET['id'])){
    $comment = getCommentFromID($_GET['id']);
  }
  
?>

<!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8">
      <title>留言板</title>
      <link rel="stylesheet" href="./style.css" />
    </head>
    <body>
      <header class="warning">注意！本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼。</header>
      <main class="board">
        <div class="board__title"><h1>編輯留言</h1></div>
        <form class="board__new-comment-form" method="POST" action="handle_update_comment.php">
          <textarea  name="content" rows="5"><?php echo $comment['content'] ?></textarea>
          <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />
          <div class="board__submit-btn"><input type="submit" value="送出" /></div>  
        </form>
      </main>
    </body>
  </html>