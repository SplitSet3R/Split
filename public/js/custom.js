function addFriend(username, token) {
    $.ajax({
        type: "POST",
        url: '/search/addfriend',
        data:  { 'username' : username },
        dataType: 'json',
        success: function(data) {
            $("button[value="+ username +"]").text(data.message);
            $("button[value="+ username +"]").prop("disabled",true);
        }
    })
};

function friendRequestResponse(username, response) {
    $.ajax({
        type: "POST",
        url: '/friends/process',
        data:  { 'username' : username, 'accepted' : response },
        dataType: 'json',
        success: function(data) {
            $("#accept-" + username).remove();
            $("#declined-" + username).remove();
            $("#feedback").text(data.message);
        }
    })
};
