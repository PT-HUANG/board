<?php 
  require_once("./conn.php");
  session_start();
  if(!empty($_SESSION['username'])){
    $username = $_SESSION['username'];
  }
  $sql = "SELECT * FROM users WHERE username= '$username'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $nickname = $row['nickname'];

  if (isset($_GET['err_code']) && $_GET['err_code'] === '1') {
    echo "<script>alert('資料不齊全')</script>";
  } 
  
?>  

<!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8">
      <title>留言板會員註冊</title>
      <link rel="stylesheet" href="./style.css" />
    </head>
    <body>
      <header class="warning">注意！本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼。</header>
      <main class="board">
        <div class="board__title"><h1>更新暱稱</h1></div>
        <div class="users_btn">
          <a href="./index.php">回首頁</a>
          <a href="login.php">登入</a>
        </div>
        <form class="board__new-comment-form" method="POST" action="handle_update_user.php">
          <div class="board__nickname">暱稱 : <input name="nickname" value="<?php echo $nickname ?>" /></div>
            <div class="board__submit-btn"><input type="submit" value="送出" /></div>
        </form>
      </main>
    </body>
  </html>