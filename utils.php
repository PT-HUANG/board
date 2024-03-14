<?php 
  function getUserFromUsername($username){
    global $conn;
    //從users資料表裡面，用row取得username, id, nickname
    $sql = "SELECT * FROM users WHERE username= '$username'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row;
  }

  function getCommentFromID($id){
    global $conn;
    //從comments資料表裡面，用row取得id, username, content
    $stmt = $conn->prepare("SELECT content FROM comments WHERE id = ?");
    $stmt->bind_param('i', $id);
    $result = $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row;
  }

  function escape($str) {
    return htmlspecialchars($str, ENT_QUOTES);
  }
?>