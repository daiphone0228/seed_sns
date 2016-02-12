<?php
session_start();
require('dbconnect.php');
require('function.php');


if (isset($_GET['tweet_id']) && !empty($_GET['tweet_id'])) {
  $sql = sprintf('SELECT m.nick_name, m.picture_path, t.* FROM `tweets` t, `members` m WHERE t.member_id = m.member_id AND t.tweet_id=%d',
    m($db, $_GET['tweet_id'])
    );
  $record = mysqli_query($db, $sql) or die (mysqli_error($db));
}

if (!empty($_POST)) {
  if ($_POST['tweet'] !='') {
    $sql = sprintf('UPDATE `tweets` SET `tweet`="%s" WHERE `tweet_id`=%d',
      m($db, $_POST['tweet']),
      m($db, $_GET['tweet_id'])
      );
    mysqli_query($db, $sql) or die (mysqli_error());

    header('Location: index.php');
    exit();
  }
}




 ?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SeedSNS</title>

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="assets/css/form.css" rel="stylesheet">
    <link href="assets/css/timeline.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body onload="document.tweet.tweet.focus()">
  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header page-scroll">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.php"><span class="strong-title"><i class="fa fa-twitter-square"></i> Seed SNS</span></a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2 content-margin-top">
        <div class="msg">
        <?php if ($tweet = mysqli_fetch_assoc($record)): ?>
          <form method="post" action="" class="form-horizontal" role="form" name="tweet">
            <img src="member_picture/<?php echo h($tweet['picture_path']); ?>" width="120" height="120">
            <p>投稿者 : <span class="name"><?php echo h($tweet['nick_name']); ?></span></p>
            <p>
              つぶやき : <br>
              <textarea name="tweet" cols="50" rows="2"><?php echo h($tweet['tweet']); ?></textarea>
            </p>
            <p class="day">
              <?php if ($tweet['created'] == $tweet['modified']) {
                echo h($tweet['created']);
              } else {
                echo h($tweet['modified']);
              } ?>
              <input type="submit" value="編集" onclick="return confirm('投稿内容を変更します。よろしいですか？')">
              [<a href="delete.php?tweet_id=<?php echo h($tweet['tweet_id']); ?>" onclick="return confirm('本当に削除してもよろしいですか？');" style="color: #F33;">削除</a>]
            </p>
          </form>
        <?php else: ?>
        <p>そのページは存在しないかURLが間違っています。</p>
        <?php endif; ?>
        <a href="index.php">&laquo;&nbsp;一覧へ戻る</a>
        </div>
      </div>
    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
