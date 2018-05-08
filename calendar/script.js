function onSignIn(googleUser) {

  var profile = googleUser.getBasicProfile();
  $(".g-signin2").css("display", "none" );

  $("#pic").attr("src", profile.getImageUrl());

  $("#email").text(profile.getEmail());

  $("#username").text(profile.getName());

  $("#calendar").css("display", "block");

  $("#profile").text("Your Profile");

  $("#set_calendar").css("display", "block");

  $("#event_id_alert").css("display", "block");


}
  function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {

    $("#invisible").css("display", "none");
    $(".g-signin2").css("display", "block" );
    $(".data").css("display", "none");
    setTimeout(function(){ window.location = 'http://localhost:8888/Group3.github.io/'; }, 1500);
    });


  }
