<?php

namespace App\Enum;

enum Industry: string
{
    case TECHNOLOGY = 'technology';
    case FINANCE = 'finance';
    case HEALTHCARE = 'healthcare';
    case EDUCATION = 'education';
    case CONSTRUCTION = 'construction';
    case ECOMMERCE = 'ecommerce';
    case MARKETING = 'marketing';
    case LOGISTICS = 'logistics';
    case GOVERNMENT = 'government';
    case OTHER = 'other';
}
