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
