<?php
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 03/04/2017
 * Time: 22:13
 */

namespace App\CustomClasses\Notifications;

use App\Friend;
use App\Notification;
use App\Expense;
use App\SharedExpense;

class NotificationManager
{
    /*Friend Notification functionality*/

    public static function makeFriendAcceptNotification(Friend $friendship) {
        $notification = new Notification;
        $notification->recipient_username = $friendship->action_username;
        $notification->sender_username = $friendship->username2;
        $notification->category = NotificationCategoryEnum::FRIEND;
        $notification->type = NotificationTypeEnum::ACTIVITY;
        $notification->reference_id = $friendship->id;
        $notification->parameters = $friendship->status_code;
        $notification->save();
    }

    /*Create a friend request notification triggered by new friend add*/
    public static function makeFriendRequestNotification(Friend $friendship) {
        $notification = new Notification;
        $notification->recipient_username = $friendship->username2;
        $notification->sender_username = $friendship->action_username;
        $notification->category = NotificationCategoryEnum::FRIEND;
        $notification->type = NotificationTypeEnum::REQUEST;
        $notification->reference_id = $friendship->id;
        //$notification->parameters = $sharedExpense->amount_owed;
        $notification->save();
    }

    public static function deleteFriendRequestNotification(Friend $friendship)
    {
        Notification::where('category', NotificationCategoryEnum::FRIEND)
            ->where('type', NotificationTypeEnum::REQUEST)
            ->where('reference_id', $friendship->id)
            ->delete();
    }


    /*Expense Request Functionality*/
    /**
     * Generate an expense request notification.
     * @param Expense $expense
     * @param Expense $sharedExpense
     */
    public static function makeExpenseRequestNotification(Expense $expense, SharedExpense $sharedExpense)
    {
        $notification = new Notification;
        $notification->recipient_username = $sharedExpense->secondary_username;
        $notification->sender_username = $expense->owner_username;
        $notification->category = NotificationCategoryEnum::EXPENSE;
        $notification->type = NotificationTypeEnum::REQUEST;
        $notification->parameters = $sharedExpense->amount_owed;
        $notification->reference_id = $sharedExpense->id;
        $notification->save();
    }
}