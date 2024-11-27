<?php

namespace App\Enum;

enum CommentStatusEnum : string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECT = 'reject';
}
