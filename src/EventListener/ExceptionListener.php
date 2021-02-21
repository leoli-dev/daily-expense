<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Twig\Environment;

class ExceptionListener
{
    /**
     * @var Environment
     */
    private Environment $twig;

    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $router;
    /**
     * ExceptionListener constructor.
     *
     * @param Environment             $twig
     * @param UrlGeneratorInterface   $router
     */
    public function __construct(
        Environment $twig,
        UrlGeneratorInterface $router
    ) {
        $this->twig = $twig;
        $this->router = $router;
    }

    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if ($exception instanceof AccessDeniedException) {
            $this->redirect401Exception($event);
        }
    }

    /**
     * @param ExceptionEvent $event
     */
    private function redirect401Exception(ExceptionEvent $event): void
    {
        $response = new RedirectResponse($this->router->generate('app_login'));

        $event->setResponse($response);
        $event->stopPropagation();
    }
}
