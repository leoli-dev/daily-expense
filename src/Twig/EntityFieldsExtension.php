<?php

namespace App\Twig;

use App\Entity\Currency;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class EntityFieldsExtension extends AbstractExtension
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * EntityFieldsExtension constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('getCurrencyFieldsData', [$this, 'getCurrencyFieldsData']),
            new TwigFunction('getAccountFieldsData', [$this, 'getAccountFieldsData']),
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

    /**
     * @return array
     */
    public function getAccountFieldsData(): array
    {
        $options = [];
        $currencyRepo = $this->entityManager->getRepository(Currency::class);
        $currencies = $currencyRepo->findAll();
        foreach ($currencies as $currency) {
            $options[] = [
                'value' => $currency->getId(),
                'content' => sprintf(
                    '%s (%s)',
                    $currency->getName(),
                    $currency->getSymbol()
                ),
            ];
        }

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
                'name' => 'currency',
                'type' => 'select',
                'required' => true,
                'options' => array_merge(
                    [
                        [
                            'value' => '',
                            'content' => 'Choose...',
                            'disabled' => true,
                        ],
                    ],
                    $options
                ),
            ],
        ];
    }
}
