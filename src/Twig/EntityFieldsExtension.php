<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class EntityFieldsExtension extends AbstractExtension
{
    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('getCurrencyFieldsData', [$this, 'getCurrencyFieldsData']),
        ];
    }

    /**
     * @return array
     */
    public function getCurrencyFieldsData(): array
    {
        return [
            [
                'name' => 'id',
                'type' => 'hidden',
            ],
            [
                'name' => 'name',
                'type' => 'text',
                'required' => true,
            ],
            [
                'name' => 'code',
                'type' => 'text',
                'required' => true,
            ],
            [
                'name' => 'symbol',
                'type' => 'text',
                'required' => true,
            ],
        ];
    }
}
