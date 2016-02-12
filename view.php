<?php
session_start();
require('dbconnect.php');
require('function.php');


if (empty($_REQUEST['tweet_id'])) {
  header('Location: index.php');
  exit();
}

// 投稿を取得する
$sql = sprintf('SELECT m.nick_name, m.picture_path, t.* FROM `tweets` t, `members` m WHERE t.member_id = m.member_id AND t.tweet_id=%d ORDER BY t.created DESC',
    m($db, $_REQUEST['tweet_id'])
    );
$tweets = mysqli_query($db, $sql) or die (mysqli_error($db));

 ?>


 <!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SeedSNS - detailed</title>

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
  <body>
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
      <div class="col-md-4 col-md-offset-4 content-margin-top">
        <div class="msg">
          <?php if ($tweet = mysqli_fetch_assoc($tweets)) { ?>
          <img src="member_picture/<?php echo h($tweet['picture_path']); ?>" width="100" height="100">
          <p>投稿者 : <span class="name"><?php echo h($tweet['nick_name']); ?></span></p>
          <p>
            つぶやき : <br>
            <?php echo makeLink(h($tweet['tweet'])); ?>
            [<a href="index.php?res=<?php echo h($tweet['tweet_id']); ?>">Re</a>]
          </p>
          <p class="day">
            <?php if ($tweet['created'] == $tweet['modified']) {
                echo h($tweet['created']);
              } else {
                echo h($tweet['modified']);
              } ?>
          <?php if ($tweet['reply_tweet_id'] > 0): ?>
            <a href="view.php?tweet_id=<?php echo h($tweet['reply_tweet_id']); ?>">
             返信元のメッセージ
            </a>
          <?php endif; ?>
          <?php if ($_SESSION['member_id'] == $tweet['member_id']): ?>
            [<a href="edit.php?tweet_id=<?php echo h($tweet['tweet_id']); ?>" style="color: #00994C;">編集</a>]
            [<a href="delete.php?tweet_id=<?php echo h($tweet['tweet_id']); ?>" onclick="return confirm('本当に削除してもよろしいですか？');" style="color: #F33;">削除</a>]
          <?php endif; ?>
          </p>
          <?php } else { ?>
          <p>This tweet couldn't find out. Please check your URL. Thank you.</p>
          <?php } ?>
        </div>
        <a href="index.php">&laquo;&nbsp;一覧へ戻る</a>
      </div>
    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
