<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
$rabbitmq = parse_url(getenv('CLOUDAMQP_URL'));
define("RABBITMQ_HOST", $rabbitmq['host']);
define("RABBITMQ_PORT", isset($rabbitmq['port']) ? $rabbitmq['port'] : 5672);
define("RABBITMQ_USERNAME", $rabbitmq['user']);
define("RABBITMQ_PASSWORD", $rabbitmq['pass']);
define("RABBITMQ_VHOST", substr($rabbitmq['path'], 1) ?: '/');
$connection = new \PhpAmqpLib\Connection\AMQPStreamConnection(
    RABBITMQ_HOST, 
    RABBITMQ_PORT, 
    RABBITMQ_USERNAME, 
    RABBITMQ_PASSWORD
);
$channel = $connection->channel();
$channel->queue_declare('task_queue', false, true, false, false);
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
$log = new Logger('gmail_queue');
$log->pushHandler(new StreamHandler(__DIR__.'/gmail_queue.log', Logger::DEBUG));
$log->addInfo('Worker ready for messages.');

$callback = function($msg){
	$log->addInfo(" [x] Received ". $msg->body);
    $job = json_decode($msg->body, $assocForm=true);
    sleep($job['sleep_period']);
	$log->addInfo(" [x] Done");
    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
	$log->warning('No warningNew task received for censoring message: ' . $msg->body);
    try {
        // call the "censor" API and pass it the text to clean up
		$log->addInfo('Here comes need to access GMAIL library ....');
            // mark as delivered in RabbitMQ
		$msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);       
    } catch(Exception $e) {
		$log->warning('Failed to call API, will retry later');
    }
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume('task_queue', '', false, false, false, false, $callback);

// loop over incoming messages
while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();