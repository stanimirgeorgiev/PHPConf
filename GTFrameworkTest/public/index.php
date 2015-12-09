<?php
$startTime = microtime(true);
include '../../GTFramework/App.php';

$app = \GTFramework\App::getInstance();
$app->run();
echo '<br />';
$endTime = microtime(true);
$elapsed = $endTime - $startTime;
?>
