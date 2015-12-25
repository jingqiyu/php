<?php
/**
 * PHP amqp(RabbitMQ) Demo-1
 * @author  jingqy
 */
$exchangeName = 'demo';
$queueName = 'hello';
$routeKey = 'hello';
$message = json_encode( array( 'id'=>1, 'key'=>'test' ) );

$amqpConfig = array(
    'host' => '127.0.0.1',
    'port' => '5672',
    'vhost' => '/',
    'login' => 'guest',
    'password' => 'guest'
);

$connection = new AMQPConnection($amqpConfig);
$connection->connect() or die("Cannot connect to the broker!\n");
try {
    $channel = new AMQPChannel($connection);
    $exchange = new AMQPExchange($channel);
    $exchange->setName($exchangeName);
    $queue = new AMQPQueue($channel);
    $queue->setName($queueName);
    $exchange->publish($message, $routeKey);
    var_dump("[x] Sent Message Done Msg'", $message );
} catch (AMQPConnectionException $e) {
    var_dump($e);
    exit();
}
$connection->disconnect();
