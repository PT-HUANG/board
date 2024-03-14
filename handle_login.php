<?php 
  session_start();
  require_once("./conn.php");
  require_once("./utils.php");

  if (empty($username)||empty($password)){
    header("Location:./login.php?err_code=1");
    die("資料不齊全");
  }

  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE username =?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $username);
  $result = $stmt->execute();

  if (!$result) {
    die($conn->error);
  }

  $result = $stmt->get_result();

  if($result->num_rows === 0) {
    header("Location:./login.php?err_code=2");
    exit();
  }

  $row = $result->fetch_assoc();
  if (password_verify($password, $row['password'])) {
    //確認輸入的密碼$password經過hash後是否等於$row['password']，如果是，登入成功
    /*
      1. 產生session ID
      2. 把username寫入localhost上面的檔案
      3. set-cookie:session ID
    */
    $_SESSION['username'] = $username;
    header("Location:./index.php");
  } else {
    header("Location:./login.php?err_code=2");
  }


?>