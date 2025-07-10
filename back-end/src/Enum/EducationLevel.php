<?php

namespace App\Enum;

enum EducationLevel: string
{
    case NONE = 'none';
    case HIGH_SCHOOL = 'high_school';
    case ASSOCIATE = 'associate';
    case BACHELOR = 'bachelor';
    case MASTER = 'master';
    case DOCTORATE = 'doctorate';
    case OTHER = 'other';

}
