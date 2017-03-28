<?php
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 26/03/2017
 * Time: 16:31
 */

namespace App\CustomClasses\Notifications;

use DB;
use Auth;
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
    //Expense, Friend
    protected $category;
    //Activity, Request, System message
    protected $type;
    protected $isRead;
    protected $parameters;
    protected $referenceId;
    protected $dateAdded;
    public function __construct($recipient, $sender, $category, $type, $parameters, $referenceId)
    {
        //id auto
        $this->recipient = $recipient;
        $this->sender = $sender;
        $this->category = $category;
        $this->type = $type;
        //default isRead to false
        $this->isRead = false;
        $this->parameters = $parameters;
        $this->referenceId = $referenceId;
        //$date-added auto

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