<?php 
  session_start();
  require_once("./conn.php");
  $nickname = $_POST['nickname'];
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  if (empty($nickname)||empty($username)||empty($password)){
    header("Location:./register.php?err_code=1");
    die("資料不齊全");
  }

  $sql = "INSERT INTO users (nickname, username, password) VALUES (?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('sss', $nickname, $username, $password);


  try {
    $result = $stmt->execute();
  } catch (Throwable $e) {
    $code = $e->getCode();
    if($code === 1062) {
      header("Location:./register.php?err_code=2");
    } 
  }

  $_SESSION['username'] = $username;
  header("Location:./index.php");


?>