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
   "edit":"https://api.salesmeet.it/api/v1/getlistuser.php?edit=0",
   "apiupdate":"",
   "items":[
      {
         "id":"1",
         "type":"checkbox",
         "value":"0",
         "description":"Corrado Facchini"
      },
      {
         "id":"2",
         "type":"checkbox",
         "value":"0",
         "description":"Federico Remiti"
      },
      {
         "id":"3",
         "type":"checkbox",
         "value":"0",
         "description":"Regina Elisabetta"
      },
      {
         "id":"4",
         "type":"checkbox",
         "value":"0",
         "description":"Maurizio ..."
      }
   ]
}
