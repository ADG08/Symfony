<?php

namespace App\Enum;

enum UserAccountStatusEnum : string
{
    case ACTIVE = 'active';
    case PENDING = 'pending';
    case Blocked = 'blocked';
    case BANNED = 'banned';
    case DELETED = 'deleted';

}
