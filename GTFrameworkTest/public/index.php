<?php
include '../../GTFramework/App.php';
$startTime = microtime(true);

$app = \GTFramework\App::getInstance();
$app->setRouterByName('GetRouter');
//phpinfo();
$app->run();
echo '<br />';
$app->getSession()->counter+=1;
echo $app->getSession()->counter;
$endTime = microtime(true);
$elapsed = $endTime - $startTime;
echo '<pre>' . print_r(\GTFramework\Loger::getInstance()->getLogs(), TRUE) . '</pre><br />';
echo '<pre>' . print_r($elapsed, TRUE) . '</pre><br />';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Form data</title>
</head>
<body>
    <h1>It's working</h1>
	<form method="POST" target="">
		<input type="text" name="KokomirchoPostva" />
		<input type="submit" name="Submitni be" value="Prashtai"/>
	</form>
</body>
</html>