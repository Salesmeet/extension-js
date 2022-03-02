<?
header("Access-Control-Allow-Origin: *");

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

$same_domain_api = "https://api.sameapp.net/public/v1/";
$url = "";
if ($type=="agenda") {
    $url = $same_domain_api . "agenda/" . $idmeeting . "/" . $lang;
} else if ($type=="partecipant") {
    $url = $same_domain_api . "partecipants/" . $idmeeting . "/" . $lang;
}
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>


  <div style="float: left; width: 7%; text-align: center;">
     <img src="https://plugin.sameapp.net/v1/img/logo.png" style="width: 70px;">
     <br><br>
     Edit meetings
     <br><br>
     <hr>
     <button onclick="exit();" id="" class="same_icon_style" title="">Close</button>
  </div>
  <div style="float: right; width: 93%;">

    <div id="spinner" style="position: absolute;z-index: 99;left: 48%;top: 40%;">
      <svg  width="970" height="70">
           <image xlink:href="https://plugin.sameapp.net/v1/img/spinner.svg" src="https://plugin.sameapp.net/v1/img/spinner.svg"/>
      </svg>
    </div>
    <div id="same_add">
      <form action="https://api.sameapp.net/public/v1/action" method="post">
        <input name="value" id="value" value="1">
        <input type="submit" value="Add item">
      </form>
    </div>
    <div id="same_common"></div>


  </div>
  <script>
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
          console.log( value );
          var myArr = JSON.parse(value);

          var myItems = myArr.items;
          var out = "";
          var i;
          var title = "";

          if (myArr.title!="") {
              title ='<b>' + myArr.title + '</b><br>';
          }

          for(i = 0; i < myItems.length; i++) {

                  out += '<button> Delete </button> ';
                  out += myItems[i].description + myItems[i].value;
                  out += "<hr>";

          }

          /*
          if (myArr.edit!="") {
            out = '\
              <div id="same_data_meeting_edit">\
              <button data-type="' + myArr.edit + '" id="same_function_edit" class="same_icon_style" title="edit"></button>\
              </div>\
              <div id="same_data_meeting_body">' + title + out + '</div>\
            ';
            // <button data-url="' + myArr.edit + '" id="same_function_check" class="same_icon_style" title="Check"></button>\

            document.getElementById("same_common").innerHTML = escapeHTMLPolicy.createHTML(out);
            // sameClickCommon( "same_function_edit" , sameFunctionEditOpen );
            // sameClickCommon( "same_function_check" , sameFindElements() );

          } else {
            out = '<div style="float:left;" id="same_data_meeting_body">' + title + out + '</div>';
            document.getElementById("same_common").innerHTML = escapeHTMLPolicy.createHTML(out);
          }
          */

          document.getElementById("same_common").innerHTML = escapeHTMLPolicy.createHTML(out);
    }


    window.onload = function() {
      sameGetAPI();
    };

  </script>
</body>
</html>
