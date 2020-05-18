<?php

namespace App\DataFixtures;

use App\Entity\Currency;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CurrencyFixtures extends Fixture
{
    public const CAD = 'currency-cad';
    public const USD = 'currency-usd';
    public const EUR = 'currency-eur';
    public const HKD = 'currency-hkd';
    public const CNY = 'currency-cny';

    public function load(ObjectManager $manager)
    {
        $cad = new Currency();
        $cad
            ->setName('Canadian dollar')
            ->setCode('CAD')
            ->setSymbol('CA$');

        $usd = new Currency();
        $usd
            ->setName('United States Dollar')
            ->setCode('USD')
            ->setSymbol('$');

        $eur = new Currency();
        $eur
            ->setName('Euro')
            ->setCode('EUR')
            ->setSymbol('€');

        $hkd = new Currency();
        $hkd
            ->setName('Hong Kong dollar')
            ->setCode('HKD')
            ->setSymbol('HK$');

        $cny = new Currency();
        $cny
            ->setName('Renminbi')
            ->setCode('CNY')
            ->setSymbol('¥');

        $manager->persist($cad);
        $manager->persist($usd);
        $manager->persist($eur);
        $manager->persist($hkd);
        $manager->persist($cny);
        $manager->flush();

        $this->addReference(self::CAD, $cad);
        $this->addReference(self::USD, $usd);
        $this->addReference(self::EUR, $eur);
        $this->addReference(self::HKD, $hkd);
        $this->addReference(self::CNY, $cny);
    }
}
