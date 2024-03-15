<?php

namespace App\API\AlarmAPIs;

enum AlarmStatus: string
{
    case ACTIVE = "ACTIVE";
    case NOT_ACTIVE = "NOT_ACTIVE";
}