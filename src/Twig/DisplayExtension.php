<?php

namespace App\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class DisplayExtension extends AbstractExtension
{
    const SESSION_KEY_SIDEBAR_TOGGLED = 'SIDEBAR_TOGGLED';

    /**
     * @var RequestStack
     */
    private RequestStack $requestStack;

    /**
     * DisplayExtension constructor.
     *
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('isSidebarToggled', [$this, 'isSidebarToggled']),
        ];
    }

    /**
     * @return bool
     */
    public function isSidebarToggled(): bool
    {
        return (bool) $this->requestStack->getCurrentRequest()->cookies->get(self::SESSION_KEY_SIDEBAR_TOGGLED);
    }
}
