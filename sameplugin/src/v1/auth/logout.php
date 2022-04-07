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
       firebase.auth().signOut();
     </script>
   </head>
   <body>
     <center>
       <img src="https://plugin.sameapp.net/v1/img/logo.png" style="width: 70px;">
       <br><br>
       Logout
     </center>
   </body>
</html>
