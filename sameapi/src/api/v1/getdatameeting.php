<?
header("Access-Control-Allow-Origin: *");
header('Content-type: application/json');
?>
{
   "title":"Summary of meeting data",
   "edit":"",
   "apiupdate":"",
   "items":[
      {
         "id":"1",
         "type":"text",
         "value":"",
         "description":"Data: <?php echo date("F j, Y, g:i a"); ?>"
      },
      {
         "id":"2",
         "type":"text",
         "value":"",
         "description":"Name: SAL Same Project"
      }
   ]
}
