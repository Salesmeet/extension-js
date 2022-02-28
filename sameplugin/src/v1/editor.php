<!DOCTYPE html>
<html>
<head>
  <script src="https://cdn.tiny.cloud/1/q8bxw8wqcr049zoy13p15fi50rgnjqfakkx9qrqnzmgt3wy4/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <style>
    body {
      margin: 0px;
    }
    .same_note_text_iframe_big {
        height: 500px !important;
    }
  </style>
</head>
<body>

    <textarea id="same_note_text_iframe"></textarea>

  <script>
    escapeHTMLPolicy = trustedTypes.createPolicy("forceInner", {
        createHTML: (to_escape) => to_escape
    })

    var contentTinymce = "";
    window.onmessage = function(e) {
        var ed = tinymce.get('same_note_text_iframe');
        contentTinymce = ed.getContent();
        // alert(tinyMCE.activeEditor.getContent());
        if (e.data.action == 'changeHeightPlus') {
              sameChangeHeight( "plus" );
        } else if (e.data.action == 'changeHeightLess') {
              sameChangeHeight( "" );
        }  else if (e.data.action == 'sameRapidCommand') {
              sameRapidCommand( e.data.value );
        } else if (e.data.action == 'sameWrite') {
              sameWrite( e.data.value);
        } else if (e.data.action == 'saveNote') {
              saveNote();
        }

    };

    function sameWrite( message ) {
      // console.log("sameWrite");
      tinymce.activeEditor.setContent( message , {format: 'html'});
    }

    function sameChangeHeight( type ) {
      // console.log("sameChangeHeight");
      var userSelection = document.getElementsByClassName("tox-tinymce");
      if (type=="plus") {
        userSelection[0].classList.add("same_note_text_iframe_big");
      } else {
        userSelection[0].classList.remove("same_note_text_iframe_big");
      }
      sameWrite( contentTinymce );
    }

    function saveNote() {
          // console.log("saveNote_Frame");
          var data = new FormData();
          data.append('idmeeting', "<?php echo $_GET['idmeeting']; ?>" );
          data.append('value', contentTinymce );
          samePostAPICommon('https://api.sameapp.net/public/v1/note',data);
    }
    function samePostAPICommon(url,data) {
          var xhr = new XMLHttpRequest();
          xhr.open('POST', url, true);
          xhr.onload = function () {
              // console.log(this.responseText);
          };
          xhr.send(data);
    }

    function sameRapidCommand( value ) {
          // console.log("sameRapidCommand: " + value);
          var el = tinymce.activeEditor.dom.create('spam', {}, value);
          tinymce.activeEditor.selection.setNode( el );
          sameChange();
    }

    function sameChange() {
        console.log("sameChange");
        var ed = tinymce.get('same_note_text_iframe');
        let temp = ed.getContent();
        temp = temp.replace("@@", "");  // 64
        temp = temp.replace("##", "");  // 35
        temp = temp.replace("]]", "");  // 93
        temp = temp.replace("[[", "");  // 91
        sameWrite( temp );
    }



    var sameCharCodeBefore = "";
    function sameKeypress( keyPressed ) {
          // console.log("sameKeypress: " + keyPressed.charCode);
          // valore per il trigger @@
          if ((keyPressed.charCode == 64) && (sameCharCodeBefore == 64)) {
              sameCall( "sameGetParticipantList" );
          } else if ((keyPressed.charCode == 35) && (sameCharCodeBefore == 35)) {
              sameCall( "sameGetAgenda" );
          } else if ((keyPressed.charCode == 93) && (sameCharCodeBefore == 93)) {
              sameCall( "sameRapidPoi" );
          }  else if ((keyPressed.charCode == 91) && (sameCharCodeBefore == 91)) {
              sameCall( "sameRapidMak" );
          }
          sameCharCodeBefore = keyPressed.charCode;
    }


    function sameCall( value ) {
      console.log("sameCall_da_Frame: ");
      window.parent.postMessage({
          'func': value,
          'message': ""
      }, "*");
    }

    var ed = tinymce.init({
        selector: '#same_note_text_iframe',
        menubar: false,
        statusbar: false,
        height: 135,
        plugins: 'link table lists checklist',
        toolbar: 'undo redo | bold italic underline strikethrough | fontsizeselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor removeformat | link | table ',
        setup : function(ed) {
            ed.on("keypress", function(keypress){
                sameKeypress( keypress );
            });
            ed.on("mouseout", function(){
                // samePostAPINote();
            });
        }
    });

    /*
  var temp2 = tinymce.activeEditor.selection.getNode();
  console.log(temp2);
  const temp = temp2.split(' ');
  // let result = temp.replace("@", "belllllaaaa");
  console.log(tinymce.activeEditor.selection.getStart());
  console.log(tinymce.activeEditor.selection.getRng());
  */
  /*
  tinymce.activeEditor.selection.setNode(
    tinymce.activeEditor.dom.create('img', {src: 'some.gif', title: 'some title'})
  );
  */
  /*
  var ed = tinymce.get('same_note_text_iframe');
  let temp2 = ed.getContent();
  console.log( temp2 );
  let result = temp2.replace("wwwww", "belllllaaaa");
  console.log( result );
  sameWrite( result );
  */
  // let result = temp.replace("@", "belllllaaaa");
  // console.log(result);
  /*
  var el = tinymce.activeEditor.dom.create('spam', {}, "belllllaaaa");
  tinymce.activeEditor.selection.setNode( el );
  */

  </script>
</body>
</html>
