<?php
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 26/03/2017
 * Time: 20:44
 */

namespace App\CustomClasses\Notifications;


class ExpenseNotification extends Notification
{
    public function __construct($recipient, $sender, $category, $type, $parameters, $referenceId)
    {
        Parent::__construct($recipient, $sender, $category, $type, $parameters, $referenceId);
    }

    /**
     * Message generators that have to be defined in subclasses
     */
    public function messageForNotification(Notification $notification)
    {
        $message = "";
        $message .= 'New Expense ';

        switch($notification->type) {
            case NotificationTypeEnum::REQUEST:
                $message .= 'request from: ';
                $message .= $notification->sender;
                $message .= ': $'.$notification->parameters;
                break;
            case NotificationTypeEnum::ACTIVITY:
                //perhaps it would be better to use this for settled expenses
                $message .= 'generated in '.$notification->parameters . ' category';
                break;
            default:
                $message .= "error";
        }
        return $message;
    }

    public function messageForNotifications(array $notifications)
    {
        $messages = array();
        foreach($notifications as $notification) {
            array_push($messages, $this->messageForNotification($notification));
        }
        return $messages;
    }
}