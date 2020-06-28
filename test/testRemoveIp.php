<?php 

require_once dirname(__DIR__)."/vendor/autoload.php";
use BlockIp\BlockIp;

//$filename = __DIR__."/ips.txt";
$data = [
    '127.0.0.1',
    '127.0.0.10',
    '127.0.0.100',
    '127.0.0.110',
    '127.0.0.111',
    '127.0.0.200',
    '127.0.0.240',
    '127.0.0.48',
    '127.144.111.14',
    '127.144.111.1',
];
$blockIp = BlockIp::getInstance($data);

$blockIp->remove(['127.0.0.1', '127.0.0.10', '127.0.0.100']);
var_dump($blockIp->remove('127.0.0.110'));
