<?php

namespace App\Helpers;

use App\Exceptions\InvalidAdminException;

class Authenticate
{
    public static function check($adminUuid)
    {
        if ($adminUuid !== getenv('ADMIN_UUID')) {
            throw new InvalidAdminException('No valid uuid given');
        }
    }
}
