<?php 
  session_start();
  require_once("./conn.php");
  $nickname = $_POST['nickname'];
  $username = $_SESSION['username'];

  if (empty($nickname)||empty($username)){
    header("Location:./update_user.php?err_code=1");
    die("資料不齊全");
  }

  $sql = "UPDATE users SET nickname=? WHERE username=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ss', $nickname, $username);


 
  $result = $stmt->execute();
  $_SESSION['username'] = $username;
  header("Location:./index.php");

?>