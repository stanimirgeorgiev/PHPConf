<?php
include '../../GTFramework/App.php';
echo "Minava includa na app <br />";
$app = \GTFramework\App::getInstance();
echo "Minava instansa na app <br />";
$app->run();
echo "Minava run na app <br />";

//foreach ($app->getConfig()->app as $k => $v) {
//    echo print_r($k).' => '.print_r($v).'<br>';
//}
