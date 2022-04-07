<?
header("Access-Control-Allow-Origin: *");
include("common/referer.php");

$idmeeting = "";
if (isset($_GET['idmeeting'])) {
    $idmeeting = $_GET['idmeeting'];
}
$lang = "";
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
}
$user = "";
if (isset($_GET['user'])) {
    $user = $_GET['user'];
}

$same_domain_api = "https://api.sameapp.net/public/v1/";
$url = $same_domain_api . "shortcut/type/" . $idmeeting . "/" . $lang . "/" . $user;
$urlInsert = $same_domain_api . "shortcut/" . $idmeeting ;
$urlDelete = "";
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>

  <div style="float: left; width: 7%; text-align: center; height: 100vh; border-right: 1px solid #767575;">
     <img src="https://plugin.sameapp.net/v1/img/logo.png" style="width: 70px;">
     <br><br>
     Edit shurtcut
     <br><br>
     <hr>
     <button onclick="exit();" id="" class="same_icon_style" title="">Close</button>
  </div>
  <div style="float: left; width: 90%; padding-left: 20px;">

    <div id="spinner" style="position: absolute;z-index: 99;left: 48%;top: 40%;">
      <svg  width="970" height="70">
           <image xlink:href="https://plugin.sameapp.net/v1/img/spinner.svg" src="https://plugin.sameapp.net/v1/img/spinner.svg"/>
      </svg>
    </div>
    <div id="same_title"></div>
    <br>
    <div id="same_add">
      <form action="" id="sameAddValueForm">
        <input name="sameAddValueShortcut" id="sameAddValueShortcut" value="" placeholder="Shortcut" >
        <input name="sameAddValue" id="sameAddValue" value="" placeholder="Value">
        <input type="button" value="Add new" onclick="javascript:addValue()">
      </form>
      <br><br>
    </div>
    <div id="same_common"></div>

  </div>
  <script>

      function encodeHTML(str){

          if (str==null) { return ""; }

          return str.replace(/([\u00A0-\u9999<>&])(.|$)/g, function(full, char, next) {
            if(char !== '&' || next !== '#'){
              if(/[\u00A0-\u9999<>&]/.test(next))
                next = '&#' + next.charCodeAt(0) + ';';

              return '&#' + char.charCodeAt(0) + ';' + next;
            }

            return full;
          });
      }

    function addValue(){
          document.getElementById("spinner").style.display = "block";
          var value = document.getElementById("sameAddValue").value;
          var shortcut = document.getElementById("sameAddValueShortcut").value;
          samePostAPICommon( "<?php echo $urlInsert; ?>", shortcut, 0 , value , "");
          document.getElementById("sameAddValue").value = "";
          document.getElementById("sameAddValueShortcut").value = "";
          setTimeout(sameGetAPI, 2000);
    }

    function deleteValue( id , value ){
          document.getElementById("spinner").style.display = "block";
          samePostAPICommon( "<?php echo $urlDelete; ?>" , value , id, "");
          setTimeout(sameGetAPI, 2000);

    }
    function samePostAPICommon(url, shortcut, type, value, call) {

          var data = new FormData();
          data.append('shortcut', shortcut );
          data.append('type', type );
          data.append('value', value );
          data.append('call', call );
          data.append('language', "<?php echo $lang; ?>" );
          data.append('user', "<?php echo $user; ?>");
          console.log(url);
          var xhr = new XMLHttpRequest();
          xhr.open('POST', url, true);
          xhr.onload = function () {
              // console.log(this.responseText);
          };
          try {
            xhr.send(data);
          } catch (error) {
          }
    }

    escapeHTMLPolicy = trustedTypes.createPolicy("forceInner", {
        createHTML: (to_escape) => to_escape
    })
    function sameGetAPI() {
          var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
               if (this.readyState == 4 && this.status == 200) {
                  // var myArr = JSON.parse(this.responseText);
                  sameCommonBlockApi(this.responseText);
                  document.getElementById("spinner").style.display = "none";
               }
          };
          xhttp.open("GET", "<?php echo $url; ?>", true);
          xhttp.send();
    }

    function exit() {
      window.parent.postMessage({
          'func': 'sameTemplateCloseParent',
          'message': ""
      }, "*");
    }

    function sameCommonBlockApi( value ) {
          // console.log( value );
          var myArr = JSON.parse(value);

          var myItems = myArr.items;
          var i;
          var title = "";

          var outHelp = "<table><tr><td style='width:70px;'><b>Shortcut</b></td><td><b>Value</b></td></tr>";
          outHelp += "<tr><td>@@</td><td>Partecipants list</td></tr>";
          outHelp += "<tr><td>##</td><td>Agenda</td></tr>";

          if (myArr.title!="") {
              title ='<b>' + myArr.title + '</b><br>';
          }
          document.getElementById("same_title").innerHTML = escapeHTMLPolicy.createHTML(title);
          for(i = 0; i < myItems.length; i++) {
                outHelp += "<tr><td>" + myItems[i].shortcut + "</td><td>" + myItems[i].value + "</td></tr>";
          }
          outHelp += "</table>";
          document.getElementById("same_common").innerHTML = escapeHTMLPolicy.createHTML(outHelp);
    }


    window.onload = function() {
      sameGetAPI();
    };

  </script>
</body>
</html>
