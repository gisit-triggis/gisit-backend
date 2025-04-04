<?php

use Symfony\Component\HttpFoundation\Response;

function getCode(int $code): int
{
    return ($code >= 200 && $code <= 599) ? $code : Response::HTTP_INTERNAL_SERVER_ERROR;
}
