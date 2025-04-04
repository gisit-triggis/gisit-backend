<?php

namespace App\Traits;

use App\Exceptions\GrpcError;

trait GrpcTrait
{
    public function handleErrors($status): void
    {
        if ($status->code != 0) {
            throw new GrpcError('code: ' . $status->code . ', message: ' . $status->details);
        }
    }
}
