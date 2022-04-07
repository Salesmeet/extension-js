<?php include("../common/referer.php") ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title></title>
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
     <script type="text/javascript">
       initApp = function() {
         firebase.auth().onAuthStateChanged(function(user) {
           if (user) {
             // User is signed in.
             var displayName = user.displayName;
             var email = user.email;
             var emailVerified = user.emailVerified;
             var photoURL = user.photoURL;
             var uid = user.uid;
             var phoneNumber = user.phoneNumber;
             var providerData = user.providerData;
             user.getIdToken().then(function(accessToken) {
               var myArr = JSON.stringify({
                 displayName: displayName,
                 email: email,
                 emailVerified: emailVerified,
                 phoneNumber: phoneNumber,
                 photoURL: photoURL,
                 uid: uid,
                 accessToken: accessToken,
                 providerData: providerData
               }, null, '  ');
               var temp = JSON.parse(myArr);

               window.parent.postMessage({
                   'func': 'sameAuthOk',
                   'message': temp.uid
               }, "*");
               /*
               document.getElementById('sign-in-status').textContent = 'Signed in';
               document.getElementById('sign-in').textContent = 'Sign out';
               document.getElementById('account-details').textContent =  JSON.stringify({
                 displayName: displayName,
                 email: email,
                 emailVerified: emailVerified,
                 phoneNumber: phoneNumber,
                 photoURL: photoURL,
                 uid: uid,
                 accessToken: accessToken,
                 providerData: providerData
               }, null, '  ');
               */
             });
           } else {
             // User is signed out.
             /*
             document.getElementById('sign-in-status').textContent = 'Signed out';
             document.getElementById('sign-in').textContent = 'Sign in';
             document.getElementById('account-details').textContent = 'null';
             */
             window.location.href = "login.php";
           }
         }, function(error) {
           console.log(error);
         });
       };

       window.addEventListener('load', function() {
         initApp()
       });
     </script>
   </head>
   <body>
     <div id="spinner" style="position: absolute;z-index: 99;left: 38%;top: 20%;">
       Authentication
       <svg  width="300" height="100">
            <image xlink:href="https://plugin.sameapp.net/v1/img/spinner.svg" src="https://plugin.sameapp.net/v1/img/spinner.svg"/>
       </svg>
     </div>
   </body>
</html>
