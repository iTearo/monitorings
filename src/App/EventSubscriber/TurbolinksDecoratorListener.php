<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Helthe\Component\Turbolinks\EventListener\TurbolinksListener;
use Helthe\Component\Turbolinks\Turbolinks;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class TurbolinksDecoratorListener implements EventSubscriberInterface
{
    protected EventDispatcherInterface $dispatcher;

    public static function getSubscribedEvents(): array
    {
        return array(
            KernelEvents::REQUEST => ['onKernelRequest'],
        );
    }

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function onKernelRequest(): void
    {
        $this->dispatcher->addSubscriber(new TurbolinksListener(new Turbolinks()));
    }
}
