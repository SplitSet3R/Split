<?php

/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 24/03/2017
 * Time: 22:08
 */
class FriendRequestNotification extends Notification
{
    /**
     * FriendRequestNotification constructor.
     * Sender, receiver, type, parameters, referenceId
     * @param $friendRequest
     */
    public function __construct($friendRequest)
    {

    }

    public function messageForNotification(Notification $notification)
    {

    }

    public function messageForNotifications(array $notifications)
    {

    }
}