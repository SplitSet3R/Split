<?php
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 26/03/2017
 * Time: 17:17
 */

namespace App\CustomClasses\Notifications;

abstract class NotificationTypeEnum
{
    const SYSTEM = 0;
    const REQUEST = 1;
    const ACTIVITY = 2;
}