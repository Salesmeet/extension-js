<?
header("Access-Control-Allow-Origin: *");
if (!isset($_GET['edit'])) {
    header('Content-type: application/json');
} else { ?>
  <script>
      function closeWindow() {
        window.parent.postMessage({
            'func': 'sameTemplateCloseParent',
            'message': ""
        }, "*");
      }
  </script>
  <button onclick="closeWindow();" id="" class="same_icon_style" title="">Close</button>
  <hr>
<?php
}
?>
{
   "edit":"https://api.sameapp.net/api/v1/getagenda.php?edit=0",
   "apiupdate":"",
   "items":[
      {
         "id":"1",
         "type":"checkbox",
         "value":"0",
         "description":"Check participants"
      },
      {
         "id":"2",
         "type":"checkbox",
         "value":"1",
         "description":"Participants presentation"
      },
      {
         "id":"3",
         "type":"checkbox",
         "value":"1",
         "description":"Reading the agenda of the day"
      },
      {
         "id":"4",
         "type":"checkbox",
         "value":"0",
         "description":"Project introduction"
      },
      {
         "id":"5",
         "type":"checkbox",
         "value":"0",
         "description":"Slide presentation"
      },
      {
         "id":"6",
         "type":"checkbox",
         "value":"0",
         "description":"..."
      },
      {
         "id":"7",
         "type":"checkbox",
         "value":"0",
         "description":"..."
      },
      {
         "id":"8",
         "type":"checkbox",
         "value":"0",
         "description":"..."
      },
      {
         "id":"9",
         "value":"0",
         "type":"checkbox",
         "description":"..."
      }
   ]
}
