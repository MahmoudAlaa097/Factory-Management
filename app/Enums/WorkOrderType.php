<?php

namespace App\Enums;

enum WorkOrderType: string
{
    case Fault      = 'fault';
    case Preventive = 'preventive';
    case Task       = 'task';
}
