<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$time = time();
$data = [];

class Welcome extends CI_Controller {

    public function index()
	{
        phpinfo();
	}

    public function consumer()
    {
        $connection = new AMQPStreamConnection('172.17.0.2', 5672, 'guest', 'guest');
        $channel = $connection->channel();

        $channel->queue_declare('task_queue', false, true, false, false);

        echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

        $callback = function($msg){
            global $time;
            echo "call back called";
            if (($time + 3) < time()) {
                echo " [x] Received ", $msg->body, "\n";
                echo " [x] Done", "\n";
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);

                $time = time();
            } else {
                echo "the time is ".$time;
            }
        };

//        $channel->basic_qos(null, 1, null);
        $channel->basic_consume('task_queue', '', false, false, false, false, $callback);

        while(count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }

    public function publisher()
    {
        $connection = new AMQPStreamConnection('172.17.0.2', 5672, 'guest', 'guest');
        $channel = $connection->channel();

        $channel->queue_declare('task_queue', false, true, false, false);

        $msg = new AMQPMessage(
            "Hello World!",
            [
                'delivery_mode' => 2
            ]
        );

        $channel->basic_publish($msg, '', 'task_queue');

        echo " [x] Sent \n";

        $channel->close();
        $connection->close();
    }
}
