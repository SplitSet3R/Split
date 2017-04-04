/*
 * Put initialization related stuff
 */
function init() {
  retrieveFriends();
}

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
            $("#" + username + " #accept").remove();
            $("#" + username + " #declined").remove();
            $("#" + username + " #feedback").text(data.message);
        }
    })
};

function retrieveFriends() {
  $( "#expOwerUsername" ).autocomplete({
    appendTo: "#expForm",
    minLength: 1,
    focus: function( event, ui ) {
      $( "#expOwerUsername" ).val( ui.item.username );
      return false;
    },
    select: function( event, ui ) {
      $("#friend-pill .friend-text").text(ui.item.username);
      $("#friend-pill").show();
      $( "#expOwerUsername" ).hide();
      return false;
    },
    source: function(request, response) {
      $.ajax({
         type : "POST",
         url: '/friends/sharedexpense',
         data: { 'search' : request.term },
         dataType: 'json',
         success: function( data ) {
           var usernames = _.map(data, d => {
             return {
               'username' : d.username,
               'firstname': d.lastname,
               'lastname' : d.firstname
             };
           });
           response( usernames );
         }
       })
    }
  }).data("uiAutocomplete")._renderItem =  function( ul, item ) {
    return $( "<li>" )
    .append( "<a>" + item.username + "</a>" )
    .appendTo( ul );
  };
}

function deleteFriendFromAddExpense() {
  $("#expOwerUsername").show();
  $("#friend-pill").hide();
}
