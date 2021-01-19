<?php

namespace App\Http\Procedures\V1\Util;

use Sajya\Server\Procedure;

class UtilProcedure extends Procedure
{
    public static string $name = 'util';

    public function ping() {
        return 'pong';
    }
}
