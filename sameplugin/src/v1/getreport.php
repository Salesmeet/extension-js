<?
header("Access-Control-Allow-Origin: *");
$idmeeting = "";
if (isset($_GET['idmeeting'])) {
    $idmeeting = $_GET['idmeeting'];
}
// $action = file_get_contents('../temp/action.txt');
// file_get_contents('../temp/note.txt');

$note = "";

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
     Edit and export
     <br>
     your report.
     <br><br>
     <hr>
     <button onclick="save();" id="" class="same_icon_style" title="">Save</button>
     <hr>
     <button onclick="exportPdf();" id="" class="same_icon_style" title="">Export PDF</button>
     <hr>
     <button onclick="" id="" class="same_icon_style" title="">Share</button>
  </div>
  <div style="float: right; width: 93%;">

    <div id="spinner" style="position: absolute;z-index: 99;left: 48%;top: 40%;">
      <svg  width="970" height="70">
           <image xlink:href="https://plugin.sameapp.net/v1/img/spinner.svg" src="https://plugin.sameapp.net/v1/img/spinner.svg"/>
      </svg>
    </div>

    <textarea id="same_note_text"><?php echo $note; ?></textarea>

  </div>
  <script>
    escapeHTMLPolicy = trustedTypes.createPolicy("forceInner", {
        createHTML: (to_escape) => to_escape
    })
    function sameGetAPI() {
          var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
               if (this.readyState == 4 && this.status == 200) {
                  var myArr = JSON.parse(this.responseText);
                  sameWrite(myArr.note);
                  document.getElementById("spinner").style.display = "none";
               }
          };
          xhttp.open("GET", "https://api.sameapp.net/public/v1/note/<?php echo $idmeeting; ?>", true);
          xhttp.send();
    }
    function sameWrite( message ) {
      // console.log("sameWrite");
      tinymce.activeEditor.setContent( message , {format: 'html'});
    }

    function save() {
      window.parent.postMessage({
          'func': 'sameSaveParentNote',
          'message': tinymce.activeEditor.getContent()
      }, "*");
    }
    function exportPdf() {
      tinymce.activeEditor.execCommand('mceExportDownload', false, {
        format: 'clientpdf',
        settings: {}
      });
    }
    window.onload = function() {
      sameGetAPI();
    };

    function loadTinyMCE() {
        tinymce.init({
          selector: 'textarea',
          plugins: 'print preview powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen image link media mediaembed template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker imagetools textpattern noneditable help formatpainter permanentpen pageembed charmap tinycomments mentions quickbars linkchecker emoticons advtable export',
          menubar: 'file edit view insert format tools table tc help',
          toolbar: 'export | undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
          height: window.innerHeight,
          statusbar: false,
          tinycomments_mode: 'embedded',
          tinycomments_author: '',
        });
    }
    loadTinyMCE();
    // const myTimeout = setTimeout(loadTinyMCE, 50);
  </script>
</body>
</html>
