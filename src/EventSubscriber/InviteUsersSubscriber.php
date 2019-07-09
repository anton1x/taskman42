<?php

namespace App\EventSubscriber;

use App\Entity\User;
use OldSound\RabbitMqBundle\RabbitMq\Producer;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use PhpAmqpLib\Exception\AMQPIOException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;

class InviteUsersSubscriber implements EventSubscriberInterface
{

    private $producer;

    public function __construct(Producer $producer)
    {
        $this->producer = $producer;
    }

    public function onSecurityAuthenticationSuccess(AuthenticationEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();

        if(!$user instanceof User){
            return false;
        }

        $email = $user->getEmail();

        $this->producer->setContentType('application/json');
        $this->producer->publish(json_encode(['email'=> $email]));

    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $clientIp = $event->getRequest()->getClientIp();
        $this->producer->setRoutingKey('blabla.kernel_request');
        try {
            $this->producer->publish($clientIp);
        }
        catch (AMQPIOException $exception){

        };
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest',
           //'security.authentication.success' => 'onSecurityAuthenticationSuccess',
        ];
    }
}
