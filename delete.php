<?php
session_start();
require('dbconnect.php');
require('function.php');

if (isset($_SESSION['member_id']) && $_SESSION['time'] + 3600 > time()) {
	$tweet_id = $_REQUEST['tweet_id'];
	
	//投稿を検査する
	$sql = sprintf('SELECT * FROM tweets WHERE tweet_id=%d',
		m($db, $tweet_id)
	);
	$record = mysqli_query($db, $sql) or die (mysqli_error($db));
	$table = mysqli_fetch_assoc($record);
	if ($table['member_id'] == $_SESSION['member_id']) {
		//削除
		$sql = sprintf('DELETE FROM tweets WHERE tweet_id=%d',
			m($db, $tweet_id)
		);
		mysqli_query($db, $sql) or die (mysqli_error($db));
	}

}


header('Location: index.php');
exit();

?>

<!-- <!DOCTYPE html>
<html lang="ja">
<head>
	<title></title>
</head>
<body>


</body>
</html> -->