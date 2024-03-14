<?php 
  require_once("./conn.php");
  if (isset($_GET['err_code']) && $_GET['err_code'] === '1') {
    echo "<script>alert('註冊資料不齊全')</script>";
  } else if (isset($_GET['err_code']) && $_GET['err_code'] === '2') {
    echo "<script>alert('註冊帳號重複')</script>";
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
        <div class="board__title"><h1>會員註冊</h1></div>
        <div class="users_btn">
          <a href="./index.php">回首頁</a>
          <a href="login.php">登入</a>
        </div>
        <form class="board__new-comment-form" method="POST" action="handle_register.php">
          <div class="board__nickname">暱稱 : <input name="nickname" placeholder="請輸入您的暱稱..." /></div>
          <div class="board__username">帳號 : <input name="username" placeholder="請輸入您的帳號..." /></div>
          <div class="board__password">密碼 : <input name="password" type="password" placeholder="請輸入您的密碼..." /></div>
            <div class="board__submit-btn"><input type="submit" value="送出" /></div>
        </form>
      </main>
    </body>
  </html>