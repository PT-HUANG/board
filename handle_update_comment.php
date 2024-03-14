<?php 
  session_start();
  require_once("./conn.php");
  require_once("./utils.php");
  $content = $_POST['content'];
  $id = $_POST['id'];
  $username = $_SESSION['username'];

  if (empty($content)){
    header("Location:./index.php?err_code=1");
    die("資料不齊全");
  }

  $sql = "UPDATE comments SET content=? WHERE id=? AND username=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('sis', $content, $id, $username);
  $result = $stmt->execute();
  
  if ($result) {
    header("Location:./index.php");
  }else {
    die($conn->error);
  }
?>