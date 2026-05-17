<?php

namespace App\Enums;

enum TaskCategory: string
{
    case Brc           = 'brc';
    case Complementary = 'complementary';
    case Other         = 'other';
}
