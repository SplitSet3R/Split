<?php

/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 24/03/2017
 * Time: 21:51
 */
abstract class Notification
{
    protected $id;
    protected $recipient;
    protected $sender;
    protected $type;
    protected $isRead;
    protected $parameters;
    protected $referenceId;
    protected $dateAdded;

    public function __construct()
    {

    }

    /**
     * Message generators that have to be defined in subclasses
     */
    public abstract function messageForNotification(Notification $notification);
    public abstract function messageForNotifications(array $notifications);

    /**
     * Generate message of the current notification.
     */
    public function message()
    {
        return $this->messageForNotification($this);
    }
}