<?php

namespace App\Enum;

enum Entitlement: string
{
    case CANDIDATE = 'candidate';
    case EMPLOYER = 'employer';
    case ADMIN = 'admin';
}
