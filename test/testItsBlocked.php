<?php 

require_once dirname(__DIR__)."/vendor/autoload.php";
use BlockIp\BlockIp;

$filename = __DIR__."/ips.txt";
$blockIp = BlockIp::getInstance($filename);

var_dump($blockIp->itsBlocked('127.0.0.111'));
