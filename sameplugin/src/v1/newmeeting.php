<?
header("Access-Control-Allow-Origin: *");

$lang = "";
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
}
$user = "";
if (isset($_GET['user'])) {
    $user = $_GET['user'];
}
$url = "";
if (isset($_GET['url'])) {
    $url = $_GET['url'];
}

$date = new DateTime();
$id = $date->getTimestamp() . uniqid();
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>

  <div>
     <img src="https://plugin.sameapp.net/v1/img/logo.png" style="width: 70px;">
     <br><br>
     I have an id:
     <form action="" id="sameSourceMeeting">
       <input name="idmeeting" id="idmeeting" value="" placeholder="meeting id" >
       <input type="button" value="Search" onclick="javascript:search();">
     </form>
     <br><hr><br>
     Create new meeting:
     <form action="" id="sameAddMeeting">
       <input name="name" id="name" value="" placeholder="Name" >
       <input name="type" id="type" value="" placeholder="Type">
       <input name="url" id="url" type="hidden" value="<?php echo $url; ?>" >
       <input name="lang" id="lang" type="hidden" value="<?php echo $lang; ?>" >
       <input name="user" id="user" type="hidden" value="<?php echo $user; ?>" >
       <input type="button" value="Add new" onclick="javascript:add()">
     </form>


  </div>
  <script>
    escapeHTMLPolicy = trustedTypes.createPolicy("forceInner", {
        createHTML: (to_escape) => to_escape
    })
    function search() {
          var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
               if (this.readyState == 4 && this.status == 200) {
                  var myArr = JSON.parse(this.responseText);
                  if (myArr.items[0].value == null ) {
                      alert("Not found.");
                  } else {
                      ok( document.getElementById("idmeeting").value );
                  }
               }
          };
          var url = "https://api.sameapp.net/public/v1/meeting/" + document.getElementById("idmeeting").value + "/<?php echo $lang; ?>/<?php echo $user; ?>";
          xhttp.open("GET", url , true);
          xhttp.send();
    }
    function add() {
          var data = new FormData();
          data.append('name', document.getElementById("name").value );
          data.append('type', document.getElementById("type").value  );
          data.append('lang', "<?php echo $lang; ?>");
          data.append('user', "<?php echo $user; ?>");
          data.append('url', "<?php echo $url; ?>");
          data.append('uniqid', "<?php echo $id; ?>");
          var xhr = new XMLHttpRequest();
          url
          xhr.open('POST', "https://api.sameapp.net/public/v1/meeting/", true);
          xhr.onload = function () {
              var myArr = JSON.parse(this.responseText);
              ok( myArr.idmeeting ) ;
          };
          try {
            xhr.send(data);
          } catch (error) {
          }
    }
    function ok( value ) {
      window.parent.postMessage({
          'func': 'sameCreateMeeting',
          'message': value
      }, "*");
    }

  </script>
</body>
</html>
