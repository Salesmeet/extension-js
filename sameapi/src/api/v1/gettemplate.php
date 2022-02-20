<?
header("Access-Control-Allow-Origin: *");

$note = "";
$idtemplate = "";
if (isset($_GET['idtemplate'])) {
    $idtemplate = $_GET['idtemplate'];
    if ($idtemplate != "") {
      $note = file_get_contents('../temp/template_' . $idtemplate . '.txt');
    }
}
$init = "";
if (isset($_GET['init'])) {
    $init = $_GET['init'];
}

?>
<!DOCTYPE html>
<html>
<head>
  <script src="https://cdn.tiny.cloud/1/q8bxw8wqcr049zoy13p15fi50rgnjqfakkx9qrqnzmgt3wy4/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body>

  <div style="float: left; width: 13%; text-align: center;">
     <img src="https://api.sameapp.net/api/img/logo.png" style="width: 70px;">
     <br><br>

     <?php echo $init; ?>
     <br>
    <!--  -->
     Choose your template
     <br><br>
     <hr>
     Template:<br><br>
     <button onclick="javascript:loadingTemplate('blank');" id="" class="same_icon_style" title="">Blank</button><br><br>
     <button onclick="javascript:loadingTemplate('meetingnotes');" id="" class="same_icon_style" title="">Meeting notes</button><br><br>
     <button onclick="javascript:loadingTemplate('projectplan');" id="" class="same_icon_style" title="">Project plan</button><br><br>
     <hr>
     <button onclick="save();" id="" class="same_icon_style" title="">Save</button><br><br>
     <?php if ($init=="") { ?>
     <button onclick="closeWindow();" id="" class="same_icon_style" title="">Close</button>
     <?php } ?>
  </div>
  <div style="float: right; width: 87%;">

    <div id="spinner" style="position: absolute;z-index: 99;left: 48%;top: 40%;">
      <svg  width="970" height="70">
           <image xlink:href="https://api.sameapp.net/api/img/spinner.svg" src="https://api.sameapp.net/api/img/spinner.svg"/>
      </svg>
    </div>

    <textarea><?php echo $note; ?></textarea>

  </div>

  <script>
      function closeWindow() {
        window.parent.postMessage({
            'func': 'sameTemplateCloseParent',
            'message': ""
        }, "*");
      }
      <?php if ($init == "init") { ?>
          function save() {
            window.parent.postMessage({
                'func': 'sameSaveParentNote',
                'message': tinymce.activeEditor.getContent()
            }, "*");
          }
      <?php } else { ?>
        function save() {
          if (confirm("By applying this template you will replace the previous data. Do you want to continue?") == true) {
            window.parent.postMessage({
                'func': 'sameSaveParentNote',
                'message': tinymce.activeEditor.getContent()
            }, "*");
          }
        }
      <?php }  ?>

      function loadingTemplate( id ) {
        window.parent.postMessage({
            'func': 'sameTemplateChoise',
            'message': id
        }, "*");
        window.location.href = "https://api.sameapp.net/api/v1/gettemplate.php?init=<?php echo $init; ?>&idtemplate=" + id;
      }
      window.onload = function() {
        document.getElementById("spinner").style.display = "none";
      };

      tinymce.init({
        selector: 'textarea',
        plugins: 'print preview powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen image link media mediaembed template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker imagetools textpattern noneditable help formatpainter permanentpen pageembed charmap tinycomments mentions quickbars linkchecker emoticons advtable export',
        menubar: 'file edit view insert format tools table tc help',
        toolbar: 'export | undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
        height: window.innerHeight,
        statusbar: false,
        tinycomments_mode: 'embedded',
        tinycomments_author: '',
      });

  </script>
</body>
</html>
