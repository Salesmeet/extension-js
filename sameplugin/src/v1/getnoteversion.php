<?
header("Access-Control-Allow-Origin: *");

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
$url = "";

?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>

  <div style="float: left; width: 7%; text-align: center;">
     <img src="https://plugin.sameapp.net/v1/img/logo.png" style="width: 70px;">
     <br><br>
     List note version
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
    <div id="same_common"></div>

  </div>
  <script>

      function encodeHTML(str){
          return str.replace(/([\u00A0-\u9999<>&])(.|$)/g, function(full, char, next) {
            if(char !== '&' || next !== '#'){
              if(/[\u00A0-\u9999<>&]/.test(next))
                next = '&#' + next.charCodeAt(0) + ';';

              return '&#' + char.charCodeAt(0) + ';' + next;
            }

            return full;
          });
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
