/**
 * Handle expense and friend notifications
 * Created by Vincent on 09/04/2017.
 */
function appendNotifications(notifications, type)
{
    if(notifications.length > 0) {
        for(var i=0; i<notifications.length; i++){
            var newnot = document.createElement('LI');
            newnot.innerHTML = notifications[i]['message'];
            //TODO confirm or deny button for requests
            //newnot.append(document.createElement('BUTTON')); confirm or deny button
            document.getElementById(type+'-notifications').append(newnot);

        }
    } else {
        var nonot = document.createElement('LI');
        nonot.innerHTML = "No " + type + " notifications";
        document.getElementById(type+'-notifications').append(nonot);
    }
}