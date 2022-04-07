<?php include("../common/referer.php") ?>

<!-- https://github.com/firebase/firebaseui-web#demo -->
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title></title>
    <style>
    .firebaseui-title, .firebaseui-subtitle {
        display: none;
    }
    .firebaseui-card-header {
        display: none;
    }
    </style>

    <script src="https://www.gstatic.com/firebasejs/9.1.3/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.1.3/firebase-auth-compat.js"></script>
     <script>
       const firebaseConfig = {
         apiKey: "AIzaSyB_bq-VMYBF7xow-C6GKi4cB3SPKbInm_w",
         authDomain: "sales-66641.firebaseapp.com",
         projectId: "sales-66641",
         storageBucket: "sales-66641.appspot.com",
         messagingSenderId: "766389546228",
         appId: "1:766389546228:web:f248e68a7d71a1309202a1",
         measurementId: "G-29D53D8B7K"
       };
       firebase.initializeApp(firebaseConfig);
     </script>
    <script src="https://www.gstatic.com/firebasejs/ui/6.0.1/firebase-ui-auth.js"></script>
    <link type="text/css" rel="stylesheet" href="https://www.gstatic.com/firebasejs/ui/6.0.1/firebase-ui-auth.css" />
    <script type="text/javascript">
      // FirebaseUI config.
      var uiConfig = {
        signInSuccessUrl: 'https://plugin.sameapp.net/v1/auth/auth.php', // '<url-to-redirect-to-on-success>',
        signInOptions: [
          /*
          firebase.auth.GoogleAuthProvider.PROVIDER_ID,
          firebase.auth.FacebookAuthProvider.PROVIDER_ID,
          firebase.auth.TwitterAuthProvider.PROVIDER_ID,
          firebase.auth.GithubAuthProvider.PROVIDER_ID,
          firebase.auth.EmailAuthProvider.PROVIDER_ID,
          firebase.auth.PhoneAuthProvider.PROVIDER_ID,
          firebaseui.auth.AnonymousAuthProvider.PROVIDER_ID
          */
          // Leave the lines as is for the providers you want to offer your users.
          firebase.auth.EmailAuthProvider.PROVIDER_ID,
        ],
        // tosUrl and privacyPolicyUrl accept either url string or a callback
        // function.
        // Terms of service url/callback.
        tosUrl: '<your-tos-url>',
        // Privacy policy url/callback.
        privacyPolicyUrl: function() {
          window.location.assign('<your-privacy-policy-url>');
        }
      };

      // Initialize the FirebaseUI Widget using Firebase.
      var ui = new firebaseui.auth.AuthUI(firebase.auth());
      // The start method will wait until the DOM is loaded.
      ui.start('#firebaseui-auth-container', uiConfig);
    </script>
  </head>
  <body>
    <center>
      <img src="https://plugin.sameapp.net/v1/img/logo.png" style="width: 70px;">
      <br><br>
      <div id="firebaseui-auth-container"></div>
      <hr>
      <a href="https://my.sameapp.net/" target="_Blank">Register</a>
    </center>
  </body>
</html>
