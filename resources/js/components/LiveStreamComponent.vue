<script src="https://apis.google.com/js/api.js"></script>
<script>
  /**
   * Sample JavaScript code for youtube.liveBroadcasts.list
   * See instructions for running APIs Explorer code samples locally:
   * https://developers.google.com/explorer-help/guides/code_samples#javascript
   */

  function authenticate() {
    return gapi.auth2.getAuthInstance()
        .signIn({scope: "https://www.googleapis.com/auth/youtube.readonly"})
        .then(function() { console.log("Sign-in successful"); },
              function(err) { console.error("Error signing in", err); });
  }
  function loadClient() {
    gapi.client.setApiKey("AIzaSyDBtlviT9jJNxH-NY_5EB9r9q7rjepycRg");
    return gapi.client.load("https://www.googleapis.com/discovery/v1/apis/youtube/v3/rest")
        .then(function() { console.log("GAPI client loaded for API"); },
              function(err) { console.error("Error loading GAPI client for API", err); });
  }
  // Make sure the client is loaded and sign-in is complete before calling this method.
  function execute() {
    return gapi.client.youtube.liveBroadcasts.list({
      "broadcastStatus": "all",
      "access_token": "AIzaSyDBtlviT9jJNxH-NY_5EB9r9q7rjepycRg"
    })
        .then(function(response) {
                // Handle the results here (response.result has the parsed body).
                console.log("Response", response);
              },
              function(err) { console.error("Execute error", err); });
  }
  gapi.load("client:auth2", function() {
    gapi.auth2.init({client_id: "69626087858-d59kjecvnand1lm7dt64f0ep7pibaib8.apps.googleusercontent.com"});
  });
</script>
<template>
<div>
    <button onclick="authenticate().then(loadClient)">authorize and load</button>
    <button onclick="execute()">execute</button>
</div>
    
</template>
<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
