<?php
/**
 * Created by PhpStorm.
 * User: Anton1x
 * Date: 29.06.2019
 * Time: 17:19
 */

namespace App\Consumer;


use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;

class EmailsConsumer implements ConsumerInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute(AMQPMessage $msg)
    {
        $body = $msg->getBody();

        $this->logger->info($body);


    }
}