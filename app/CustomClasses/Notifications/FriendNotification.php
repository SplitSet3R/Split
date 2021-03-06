<?php
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 26/03/2017
 * Time: 16:40
 */
namespace App\CustomClasses\Notifications;
class FriendNotification extends Notification
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
        switch($notification->type) {
            case NotificationTypeEnum::REQUEST:
                $message .= 'New friend request from: ' . $notification->sender;
                break;
            case NotificationTypeEnum::ACTIVITY:
                $message .= $notification->sender. ' ' . $notification->parameters .' your friend request!';
                break;
            default:
                $message .= "error ";
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