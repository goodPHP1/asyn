<?php
header("content-type:text/html;charset=utf-8");
//error_reporting(0);
//ini_set('html_errors',false);
//ini_set('display_errors',false);
$name = isset($_POST['name'])?$_POST['name']:'';
$pwd = isset($_POST['pwd'])?$_POST['pwd']:'';
sleep(10);
file_put_contents('E:/wamp64/www/ceshi.php', $name);
echo $name.$pwd;
echo 'success ok';
die;
?>