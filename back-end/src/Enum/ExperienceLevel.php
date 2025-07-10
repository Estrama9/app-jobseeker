<?php

namespace App\Enum;

enum ExperienceLevel: string
{
    case INTERN = 'intern';
    case ENTRY = 'entry';
    case MID = 'mid';
    case SENIOR = 'senior';
    case LEAD = 'lead';
    case DIRECTOR = 'director';
    case EXECUTIVE = 'executive';

}

