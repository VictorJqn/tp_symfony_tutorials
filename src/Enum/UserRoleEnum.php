<?php

declare(strict_types=1);

namespace App\Enum;

enum UserRoleEnum : string
{

    case ADMIN = "admin";
    case USER = "user";
    case BANNED = "banned";
}