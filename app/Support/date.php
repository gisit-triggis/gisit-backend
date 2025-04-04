<?php

function getFullDate(DateTimeInterface $date): string
{
    return $date->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s');
}

function getOnlyDate(DateTimeInterface $date): string
{
    return $date->setTimezone(config('app.timezone'))->format('Y-m-d');
}

function getOnlyTime(DateTimeInterface $date): string
{
    return $date->setTimezone(config('app.timezone'))->format('H:i:s');
}
