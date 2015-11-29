<?php
$startTime = microtime(true);
include '../../GTFramework/App.php';

$app = \GTFramework\App::getInstance();
$app->run();
echo '<br />';
$endTime = microtime(true);
$elapsed = $endTime - $startTime;
//echo '<pre>' . print_r($elapsed, TRUE) . '</pre><br />';
//echo '<pre>' . print_r($_COOKIE, TRUE) . '</pre><br />';
//echo '<pre>' . print_r($_ENV, TRUE) . '</pre><br />';
//echo '<pre>' . print_r($_FILES, TRUE) . '</pre><br />';
//echo '<pre>' . print_r($_GET, TRUE) . '</pre><br />';
//echo '<pre>' . print_r($_POST, TRUE) . '</pre><br />';
//echo '<pre>' . print_r($_REQUEST, TRUE) . '</pre><br />';
//echo '<pre>' . print_r($_SERVER, TRUE) . '</pre><br />';
//echo '<pre>' . print_r($_SESSION, TRUE) . '</pre><br />';
?>
