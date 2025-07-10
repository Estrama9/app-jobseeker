<?php

namespace App\Enum;

enum JobType: string
{
    case FULL_TIME = 'full_time';
    case PART_TIME = 'part_time';
    case FREELANCE = 'freelance';
    case INTERSHIP = 'intership';
}
