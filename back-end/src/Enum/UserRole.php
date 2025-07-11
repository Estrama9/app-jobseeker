<?php

namespace App\Enum;

enum UserRole: string {
    case USER = 'ROLE_USER';
    case CANDIDATE = 'ROLE_CANDIDATE';
    case EMPLOYER = 'ROLE_EMPLOYER';
    case ADMIN = 'ROLE_ADMIN';
}

