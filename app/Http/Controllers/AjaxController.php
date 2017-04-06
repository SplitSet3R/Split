<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Friend;
use DB;
use App\CustomClasses\Notifications\FriendNotification;
use App\CustomClasses\Notifications\NotificationManager;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    /*
     * AJAX Request to handle adding a friend specified in the request
     * conducted by the user currently authenticated
     */
    public function addfriend(Request $req)
    {
        if ($req->json() && isset($req->username)) {
            $friendstatus = Friend::whereIn('username1', [Auth::user()->username, $req->username])
                ->whereIn('username2', [Auth::user()->username, $req->username])
                ->count();
            if ($friendstatus < 1) { // Authenticated user is not friends with $req->username
                $friendship = new Friend;
                $friendship->username1 = Auth::user()->username;
                $friendship->username2 = $req->username;
                $friendship->status_code = 'pending';
                $friendship->action_username = Auth::user()->username;
                $friendship->save();
                NotificationManager::makeFriendRequestNotification($friendship); //generate notification on success
                return response()->json(array("message" => "friend request sent!"), 200);
            }
        }
        return response()->json(array("message" => "generic error message"), 500);
    }

    /*
     * AJAX Request to handle accepting/declining a friend request
     */
    public function processFriendRequest(Request $req)
    {
        if ($req->json() && isset ($req->username)) {
            $friendship = Friend::where('username2', '=', Auth::user()->username)
                ->where('username1', '=', $req->username)
                ->where('status_code', '=', 'pending')
                ->where('action_username', '!=', Auth::user()->username)
                ->first();

            if (isset ($req->accepted)) {
                if ($req->accepted == 'accepted') {
                    $friendship->status_code = 'accepted';
                    $friendship->save();
                    /*friend request now says has accepted your friend request*/
                    NotificationManager::deleteFriendRequestNotification($friendship);
                    NotificationManager::makeFriendAcceptNotification($friendship);
                    return response()->json(array("message" => "friend request accepted!"), 200);
                } else if ($req->accepted == 'declined') {
                    $friendship->status_code = 'declined';
                    $friendship->save();
                    /*set previous friend req notification to denied*/
                    NotificationManager::deleteFriendRequestNotification($friendship);
                    return response()->json(array("message" => "friend request denied!"), 200);
                }
            }
            // accepted is a temp name; may change
        }
        return response()->json(array("message" => "generic error message"), 500);
    }

    /**
     * Ajax Request to retrieve a user's friends
     *
     */
    public function retrieveFriends(Request $req)
    {

        if ($req->json() && isset($req->search)) {
            $terms = explode(" ", $req->search);

            $friends = Auth::user()->acceptedFriends()->filter(function ($d) use ($terms) {
                foreach ($terms as $term) {
                    if (strpos($d->username, $term) !== false || strpos($d->firstname, $term) !== false || strpos($d->lastname, $term) !== false) {
                        return true;
                    }
                }

                return false;
            });

            return response()->json($friends, 200);
        }

        return response()->json(array("message" => "generic error message"), 500);
    }

    /*
     * Get notifications where user is the recipient of the request.
     * TODO currently only FRIEND notifications: add expense notifications too
     * TODO set a cap on how many notifications to pull.
     * @return an array of arrays. Each sub array contains 1. Notification object, 2. Notification message (string)
     */
    public function getNotifications(Request $req)
    {
        if ($req->ajax()) {
            $requests = DB::table('notifications')
                ->where('recipient_username', Auth::user()->username)
                ->where('category', 2)//category 2 is for just Friend notifications
                //->where('type', 1) //Just request notifications
                ->orderBy('is_read', 'ASC')
                ->get();
            $notifications = array();
            foreach ($requests as $request) {
                $n = new FriendNotification($request->recipient_username,
                    $request->sender_username, $request->category,
                    $request->type, $request->parameters, $request->reference_id);

                array_push($notifications, array('refid' => $request->reference_id, 'message' => $n->messageForNotification($n)));
            }
            return response()->json(array("requestnotifications" => $notifications));
        } else {
            return response()->json(array("error" => "error with notifications"));
        }
    }

    /**
     * Update a notification once it has been viewed.
     * @param Request $req
     */
    public function updateNotifications(Request $req)
    {
        //update when viewed
        if ($req->ajax()) {
            if (isset($req->viewed)) {
                dd($req->viewed);
            }
        }
    }
}
