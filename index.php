<?php 
  session_start();
  require_once("./conn.php");
  require_once("./utils.php");
  if (isset($_GET['err_code']) && $_GET['err_code'] === '1') {
    echo "<script>alert('資料不齊全')</script>";
  }
  /*
    1. 從 cookie 裡面讀取 PHPSSID(token)
    2. 從檔案裡面讀取 session id 的內容
    3. 放到 $_SESSION
  */
  $username = NULL;
  if(!empty($_SESSION['username'])){
    $username = $_SESSION['username'];
    $user = getUserFromUsername($username);
    $nickname = $user['nickname'];
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
        <div class="board__title"><h1>Comments</h1></div>
        <div class="users_btn">
          <?php if (!$username){ ?>
            <a href="register.php">註冊</a>
            <a href="login.php">登入</a>
          <?php } else{ ?>
          <?php echo "<text>你好，" . $nickname ."</text>" ?>  
            <a href="update_user.php">修改</a>
            <a href="logout.php">登出</a>
          <?php }?>  
        </div>
        <?php if ($username){ ?>
          <form class="board__new-comment-form" method="POST" action="handle_add_comment.php">
            <div class="content_and_submit">
              <textarea  name="content" placeholder="想說些什麼..." rows="5"></textarea>
              <div class="board__submit-btn"><input type="submit" value="留言" /></div>
            </div>
          </form>
        <?php }else { ?>
          <h3>請登入發布留言</h3>
        <?php } ?>
        <div class="line">_________________________________________________________________</div><br>
        <section>
          <?php

            $page = 1;
            if(!empty($_GET['page'])) {
              $page = $_GET['page'];
            }
            $items_per_page = 5; //items_per_page也可以用limit代換
            $offset = ($page-1)*$items_per_page;


            $stmt = $conn->prepare(
              'SELECT ' .
                'C.id as id, C.content as content, C.created_at as created_at, ' .
                'U.nickname as nickname, U.username as username ' .
              'FROM comments as C ' . 
              'LEFT JOIN users as U ON C.username = U.username ' .
              'WHERE C.is_deleted is NULL ' .
              'ORDER BY C.id DESC ' .
              'limit ? offset ? '
            );
            $stmt->bind_param('ii', $items_per_page, $offset);
            $result = $stmt->execute();
            $result = $stmt->get_result();
            while($row = $result->fetch_assoc()) {
              $nickname = $row['nickname']; 
              $content = $row['content'];
              $created_at = $row['created_at'];
          ?>
            <div class='card'>
              <div class='card__icon'></div>
              <div class='card__info'>
              <?php 
                echo "<span class='card__info__author'>" . escape($nickname). "(@" . escape($row['username']) . ")" ."</span>";
                echo "<span class='card__info__time'>" . escape($created_at) . "</span>";
              ?>
              <?php if($row['username'] === $username) { ?>
                <a href="update_comment.php?id=<?php echo $row['id']?>">編輯留言</a>
                <a href="delete_comment.php?id=<?php echo $row['id']?>">刪除留言</a>
              <?php } 
              echo "<div class='card__info__content'>" . escape($content) . "</div>";
              ?>
              </div>
            </div>
            <?php }
            ?>
        </section>
        <div class="line">_________________________________________________________________</div><br>
        <?php
          $stmt = $conn->prepare(
            'SELECT count(id) as count from comments where is_deleted IS NULL' 
          );
          $result = $stmt->execute();
          $result = $stmt->get_result();
          $row = $result->fetch_assoc();
          $count = $row['count'];
          $total_page = ceil($count / $items_per_page);
        ?>
        <div class="comment_info">
          共有 <?php echo $count ?> 筆留言，
          目前分頁:<?php echo $page ?> / <?php echo $total_page ?>
        </div>
        <div class="paginator">
          <a href="index.php?page=1">第一頁</a>
          <?php
            if ($page > 1){
              echo "<a href='index.php?page=" . $page-1 ."'>上一頁</a>";
            }else {
              echo "<a href='index.php?page=1'>上一頁</a>";
            }
            if ($page < $total_page){
              echo "<a href='index.php?page=" . $page+1 ."'>下一頁 </a>";
            }else {
              echo "<a href='index.php?page=" . $total_page ."'>下一頁</a>";
            }?>
          <a href="index.php?page=<?php echo $total_page?>">最後一頁</a>
        </div>
      </main>
    </body>
  </html>