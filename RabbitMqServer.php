<?php
/**
 * Created by PhpStorm.
 * User: jingqy
 * Date: 2015/12/25
 * Time: 11:05
 */


$amqpConfig = array(
    'host' => '127.0.0.1',
    'port' => '5672',
    'vhost' => '/',
    'login' => 'guest',
    'password' => 'guest'
);

$exchangeName = "demo";
$connection = new AMQPConnection( $amqpConfig );
$connection->connect() or die ( "Cannot Connect to the broker ");
$channel = new AMQPChannel( $connection );
$exchange = new AMQPExchange($channel);
$exchange->setType(AMQP_EX_TYPE_DIRECT);
$exchange->setName($exchangeName);
$exchange->declareExchange();


$queName = "hello";
$routKey = "hello";
$queue = new AMQPQueue($channel);
$queue->setName($queName);
$queue->declareQueue();
$queue->bind($exchangeName,$routKey);

var_dump( '[*] 正在等待消息 ------- ');

while (TRUE) {
    $queue->consume('callback');
}
$connection->disconnect();
function callback($envelope, $queue) {
    $msg = $envelope->getBody();
    var_dump(" [x] Received:" . $msg);
    $queue->nack($envelope->getDeliveryTag());
}