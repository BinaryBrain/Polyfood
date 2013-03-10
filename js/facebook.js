function login() {
  FB.login(function(response) {
      if (response.authResponse) {
	  // connected
	  console.log("logged in")
	  testAPI()
      } else {
	  // cancelled
	  console.log("Connection cancelled")
      }
  });
}

function testAPI() {
  console.log('Welcome!  Fetching your information.... ');
  FB.api('/me', function(response) {
      console.log(response)
      console.log('Good to see you, ' + response.name + '.');
  });
  FB.api('/me/feed', function(response) {
      console.log(response)
  });
}


window.fbAsyncInit = function() {
  FB.init({
    appId      : '312224588840695', // App ID
    channelUrl : 'fb/channel.html', // Channel File
    status     : true, // check login status
    cookie     : true, // enable cookies to allow the server to access the session
    xfbml      : true  // parse XFBML
  });
  
  FB.getLoginStatus(function(response) {
    console.log(response.status)
    if (response.status === 'connected') {
      // connected
      testAPI()
    } else if (response.status === 'not_authorized') {
      // not_authorized
      login()
    } else {
      // not_logged_in
      login()
    }
  });
};

// Load the FB SDK Asynchronously
(function(d){
   var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement('script'); js.id = id; js.async = true;
   js.src = "//connect.facebook.net/en_US/all.js";
   ref.parentNode.insertBefore(js, ref);
} (document));
