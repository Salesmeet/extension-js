<?
header("Access-Control-Allow-Origin: *");
include("common/referer.php");

$idmeeting = "";
if (isset($_GET['idmeeting'])) {
    $idmeeting = $_GET['idmeeting'];
}
$type = "";
if (isset($_GET['type'])) {
    $type = $_GET['type'];
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
$url = "";
$urlInsert = "";
$urlDelete = "";
$sameAddValueField_placeholder = "";
$sameAddEmail_type = "";
$sameMessage = "";

if ($type=="agenda") {
    $url = $same_domain_api . "agenda/" . $idmeeting . "/" . $lang . "/" . $user;
    $urlInsert = $same_domain_api . "agenda/insert";
    $urlDelete = $same_domain_api . "agenda/delete";
    $sameAddValueField_placeholder = "Value";
    $sameAddEmail_type = "hidden";
    $sameMessage = "sameTemplateCloseParentGetAgenda";

} else if ($type=="partecipant") {

    $url = $same_domain_api . "partecipants/" . $idmeeting . "/" . $lang . "/" . $user;;
    $urlInsert = $same_domain_api . "partecipants/insert";
    $urlDelete = $same_domain_api . "partecipants/delete";
    $sameAddValueField_placeholder = "Name";
    $sameAddEmail_type = "text";
    $sameMessage = "sameTemplateCloseParentGetParticipantList";

}
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>

  <div style="float: left; width: 7%; text-align: center; height: 100vh; border-right: 1px solid #767575;">
     <img src="https://plugin.sameapp.net/v1/img/logo.png" style="width: 70px;">
     <br><br>
     Edit meetings
     <br><br>
     <hr>
     <button onclick="javascript:changeType('agenda');" id="" class="same_icon_style" title="">Agenda</button>
     <br><br>
     <button onclick="javascript:changeType('partecipant');" id="" class="same_icon_style" title="">Partecipants</button>
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
        <input name="sameAddValueField" id="sameAddValueField" value="" placeholder="<?php echo $sameAddValueField_placeholder; ?>" >
        <input name="sameAddEmail" id="sameAddEmail" value="" type="<?php echo $sameAddEmail_type; ?>" placeholder="Email">
        <input type="button" value="Add new" onclick="javascript:addValue()">
      </form>
      <br><br>
    </div>
    <div id="same_common"></div>

  </div>
  <script>


      function changeType(type){
          window.location.href = "https://plugin.sameapp.net/v1/getmeeting.php?idmeeting=<?php echo $idmeeting ?>&type=" + type + "&lang=<?php echo $lang ?>&user=<?php echo $user ?>";

      }

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
          var value = document.getElementById("sameAddValueField").value;
          var email = document.getElementById("sameAddEmail").value;
          samePostAPICommon( "<?php echo $urlInsert; ?>" , value , "", email);
          document.getElementById("sameAddValueField").value = "";
          setTimeout(sameGetAPI, 2000);
    }

    function deleteValue( id , value ){
          document.getElementById("spinner").style.display = "block";
          samePostAPICommon( "<?php echo $urlDelete; ?>" , value , id, "");
          setTimeout(sameGetAPI, 2000);

    }
    function samePostAPICommon(url, value, id, email) {

          var data = new FormData();
          data.append('value', value );
          data.append('email', email );
          data.append('id', id );
          data.append('idmeeting', "<?php echo $idmeeting; ?>");
          data.append('user', "<?php echo $user; ?>");
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
          'func': '<?php echo $sameMessage; ?>',
          'message': ""
      }, "*");
    }
    function sameCommonBlockApi( value ) {
          // console.log( value );
          var myArr = JSON.parse(value);

          var myItems = myArr.items;
          var out = "";
          var i;
          var title = "";

          if (myArr.title!="") {
              title ='<b>' + myArr.title + '</b><br>';
          }
          document.getElementById("same_title").innerHTML = escapeHTMLPolicy.createHTML(title);


          for(i = 0; i < myItems.length; i++) {

                  var enValue = encodeHTML(myItems[i].value);
                  out += '<img style="width:14px; cursor: pointer;" src="https://plugin.sameapp.net/v1/img/delete.png" onclick="javascript:deleteValue(' + i +  ',\'' + enValue + '\')">  ';
                  if (myItems[i].checked==1) {
                      out += "<b>" + myItems[i].value + "</b>";
                  } else {
                      out += myItems[i].value;
                  }
                  out += "<hr>";

          }
          document.getElementById("same_common").innerHTML = escapeHTMLPolicy.createHTML(out);
    }

    window.onload = function() {
      sameGetAPI();
    };

  </script>
</body>
</html>
