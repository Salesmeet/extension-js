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

$idnote = "";
if (isset($_GET['idnote'])) {
    $idnote = $_GET['idnote'];
}


$same_domain_api = "https://api.sameapp.net/public/v1/";
$urlAll = $same_domain_api . "note/all/" . $idmeeting . "/" . $lang . "/" . $user;

$urlLast = $same_domain_api . "note/" . $idmeeting;
if ($idnote !="") {
    $urlLast = $same_domain_api . "note/id/" . $idnote;
}

?>

<!DOCTYPE html>
<html>
<head>
  <script src="https://cdn.tiny.cloud/1/q8bxw8wqcr049zoy13p15fi50rgnjqfakkx9qrqnzmgt3wy4/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body>

  <div style="float: left; width: 7%; text-align: center;">
     <img src="https://plugin.sameapp.net/v1/img/logo.png" style="width: 70px;">
     <br><br>
     List note version
     <br><br>
     <div id="same_list" style="height: 400px; overflow: auto;"></div>
     <hr>
     <button onclick="save();" id="" class="same_icon_style" title="">Save</button>
     <hr>
     <button onclick="exit();" id="" class="same_icon_style" title="">Close</button>
  </div>
  <div style="float: left; width: 90%; padding-left: 20px;">

    <div id="spinner" style="position: absolute;z-index: 99;left: 48%;top: 40%;">
      <svg  width="970" height="70">
           <image xlink:href="https://plugin.sameapp.net/v1/img/spinner.svg" src="https://plugin.sameapp.net/v1/img/spinner.svg"/>
      </svg>
    </div>

    <textarea id="same_note_text"></textarea>

  </div>
  <script>

    escapeHTMLPolicy = trustedTypes.createPolicy("forceInner", {
        createHTML: (to_escape) => to_escape
    })
    function sameGetAPI() {
          var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
               if (this.readyState == 4 && this.status == 200) {
                  sameCommonBlockApi(this.responseText);
               }
          };
          xhttp.open("GET", "<?php echo $urlAll; ?>", true);
          xhttp.send();
    }
    function sameGetAPILast() {
          var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
               if (this.readyState == 4 && this.status == 200) {
                  var myArr = JSON.parse(this.responseText);
                  sameWrite( myArr["note"] )
                  document.getElementById("spinner").style.display = "none";
               }
          };
          xhttp.open("GET", "<?php echo $urlLast; ?>", true);
          xhttp.send();
    }

    function save() {
      window.parent.postMessage({
          'func': 'sameSaveParentNote',
          'message': tinymce.activeEditor.getContent()
      }, "*");
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
          // console.log(myArr);
          myArr.sort(function (a, b) {
            return a.date.localeCompare(b.date) || b.price - a.price;
        });

          var out = "";
          for(i = 0; i < myArr.length; i++) {
                out += '<a href="?idmeeting=<?php echo $idmeeting ?>&lang=<?php echo $lang ?>&user=<?php echo $user ?>&idnote=' +  myArr[i].id + '">' + myArr[i].date + '</a>';
                out += "<hr>";
                if (i==0) {
                      myArr[i].id
                }
                /*
                console.log(myArr[i].date);
                console.log( new Date(myArr[i].date) );
                console.log("__________________");
                */
          }
          document.getElementById("same_list").innerHTML = escapeHTMLPolicy.createHTML(out);
    }

    function sameWrite( message ) {
      // console.log("sameWrite");
      tinymce.activeEditor.setContent( message , {format: 'html'});
    }
    function loadTinyMCE() {
        tinymce.init({
          selector: 'textarea',
          menubar: false,
          statusbar: false,
          height: 135,
          plugins: 'link table lists checklist',
          toolbar: 'undo redo | bold italic underline strikethrough | fontsizeselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor removeformat | link | table ',
          height: window.innerHeight,
          statusbar: false,
          tinycomments_mode: 'embedded',
          tinycomments_author: '',
        });
    }
    loadTinyMCE();

    window.onload = function() {
      sameGetAPI();
      sameGetAPILast();
    };

  </script>
</body>
</html>
