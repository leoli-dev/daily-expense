<?php

namespace App\Model;

class FlowType
{
    public const INCOME = 0;
    public const EXPENSE = 1;
    public const TRANSFER = 2;

    public const OPTIONS = [
        self::INCOME,
        self::EXPENSE,
        self::TRANSFER,
    ];
}
