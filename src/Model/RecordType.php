<?php

namespace App\Model;

class RecordType
{
    public const TYPE_GAIN = 1;
    public const TYPE_LOSS = 2;
    public const TYPE_TRANSFER = 3;

    public const TYPES = [
        self::TYPE_GAIN,
        self::TYPE_LOSS,
        self::TYPE_TRANSFER,
    ];
}
