<?php

namespace App\Enum;

enum WorkMode: string
{
    case REMOTE = 'remote';
    case ON_SITE = 'on_site';
    case HYBRID = 'hybrid';
}
