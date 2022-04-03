<!DOCTYPE html>
<html>
<head>
  <script src="https://cdn.tiny.cloud/1/q8bxw8wqcr049zoy13p15fi50rgnjqfakkx9qrqnzmgt3wy4/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

  <link href='fullcalendar/lib/main.css' rel='stylesheet' />
  <script src='fullcalendar/lib/main.js'></script>
  <script src='fullcalendar/lib/locales-all.js'></script>

  <style>
    body {
      margin: 0px;
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
        if (e.data.action == 'changeHeight') {
              sameChangeHeight();
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
      tinyMCE.activeEditor.focus();
    }

    function sameChangeHeight() {
      document.head.insertAdjacentHTML("beforeend", '<style> .same_note_text_iframe_dynamic { height: ' + document.documentElement.clientHeight + 'px !important;}</style>')
      var userSelection = document.getElementsByClassName("tox-tinymce");
      userSelection[0].classList.remove("same_note_text_iframe_dynamic");
      userSelection[0].classList.add("same_note_text_iframe_dynamic");
      sameWrite( contentTinymce );
    }

    function saveNote() {
          // console.log("saveNote_Frame");
          var data = new FormData();
          data.append('idmeeting', "<?php echo $_GET['idmeeting']; ?>" );
          data.append('user', "<?php echo $_GET['user']; ?>" );
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

    var same_shortcut_list = [];
    function sameGetShortcut() {
          var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
               if (this.readyState == 4 && this.status == 200) {
                   var myArr = JSON.parse( this.responseText );
                   var myItems = myArr.items;
                   same_shortcut_list = myArr.items;
               }
          };
          xhttp.open("GET", "https://api.sameapp.net/public/v1/shortcut/type/<?php echo $_GET['idmeeting']; ?>/<?php echo $_GET['lang']; ?>/<?php echo $_GET['user']; ?>" , true);
          xhttp.send();
    }

    function sameRapidCommand( value ) {

          console.log("sameRapidCommand:" + value.type);

          if (value.type=="rCalendar") {

              sameViewCalendar(value);

          } else {

              console.log("sameRapidCommand:" + value);
              var char_i = "[ ";
              var char_e = " ]";

              var timeDefault = value.timeDefault;
              var hrs = ~~(timeDefault / 3600);
              var mins = ~~((timeDefault % 3600) / 60);
              var secs = ~~timeDefault % 60;
              var temp = mins + ":" + secs;
              // var timeDefault = char_i + value.timeDefault + char_e ;
              var timeDefaultString = char_i + temp + char_e ;
              var time = "";
              if (value.time != "") {
                time = char_i + value.time + char_e ;
              }
              var valore = value.value;
              if (value.type == "data") {
              } else if (value.type == "calendar") {
                valore = value.value ;
              } else if (value.type == "participant") {
                valore = char_i + "@"  + char_e + " " + char_i + value.value + char_e ;
              } else if ( value.type == "agenda") {
                valore = timeDefaultString + time + char_i + "Agenda" + char_e + " " + value.value  ;
              } else {
                valore = timeDefaultString + time + char_i + value.value  + char_e;
              }
              console.log(value.timeDefault);
              console.log(value.time);
              console.log(value.type);
              // var json = {"type": type, "value": value, "timeDefault": sameDefaulTotalSeconds, "time": time};

              // Prendo il vavlore
              var temp2 = tinymce.activeEditor.selection.getNode().innerHTML;
              // sostituisco il valore
              temp2 = temp2.replace("@@", "");  // 64
              temp2 = temp2.replace("##", "");  // 35

              for(i = 0; i < same_shortcut_list.length; i++) {
                  temp2 = temp2.replace( same_shortcut_list[i].shortcut , "");
              }

              // Cancello i valori del nodo
              tinymce.activeEditor.selection.getNode().innerHTML = "";
              // Creo un nuovo nodo
              var el = tinymce.activeEditor.dom.create('spam', {}, temp2 + valore  + " ");
              tinymce.activeEditor.selection.setNode( el );

              tinyMCE.activeEditor.focus();

          }


    }

    var sameCharCodeBefore = "";
    var sameWord = "";
    function sameKeypress( keyPressed ) {
          // console.log("sameKeypress: " + keyPressed.charCode);
          // valore per il trigger @@
          if ((keyPressed.charCode == 64) && (sameCharCodeBefore == 64)) {
              sameCall( "sameGetParticipantList", "" );
          } else if ((keyPressed.charCode == 35) && (sameCharCodeBefore == 35)) {
              sameCall( "sameGetAgenda", "" );
          }
          sameCharCodeBefore = keyPressed.charCode;
          // spazio ...
          if ( keyPressed.charCode == 32) {
              sameWord = "";
          } else {
              sameWord += keyPressed.key;
          }
          if (sameWord.length > 2) {

            for(i = 0; i < same_shortcut_list.length; i++) {
                if (sameWord==same_shortcut_list[i].shortcut) {
                    sameWord = "";
                    var temp = '{"value":"' + same_shortcut_list[i].value + '","shortcut":"' + same_shortcut_list[i].shortcut + '","type":"' + same_shortcut_list[i].call + '"}';
                    sameCall( "sameEditorRapidCommad", temp );
                }
            }
          }
    }
    function sameKeydown( keyDown ) {
        if (keyDown.key=="Enter") {
            sameWord = "";
        }
    }
    function sameCall( value , message ) {
      window.parent.postMessage({
          'func': value,
          'message': message
      }, "*");
    }

    // plugins: 'link table lists checklist',
    var ed = tinymce.init({
        selector: '#same_note_text_iframe',
        menubar: false,
        statusbar: false,
        height: 500,
        plugins: 'link table lists',
        toolbar: 'customInsertButton | undo redo | bold italic underline strikethrough | fontsizeselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | link | table ',
        setup : function(ed) {
            ed.on("keypress", function(keypress){
                sameKeypress( keypress );
            });
            ed.on("keydown", function(keydown){
                sameKeydown( keydown );
            });
            ed.on("mouseout", function(){
                // samePostAPINote();
            });
            ed.ui.registry.addButton('customInsertButton', {
              text: 'SHORTCUTS',
              onAction: function (_) {
                sameCall( "sameChangePanelSetting", "" );
                // ed.insertContent('&nbsp;<strong>Shortcuts</strong>&nbsp;');
              }
            });

        }
    });

    window.onload = function() {
        sameGetShortcut();
    };

  </script>


  <div id='calendar' style="visibility:hidden;position: absolute;
    top: 0px;
    width: 100%;
    z-index: 999999;
    background: #ffffff;"></div>
  <script>

      var calendarEl = document.getElementById('calendar');

      var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },
        buttonIcons: false, // show the prev/next text
        weekNumbers: true,
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        dayMaxEvents: true, // allow "more" link when too many events
        selectable: true,
        dateClick: function(info) {
          // alert("dateClick");
        },
        select: function(info) {
          sameViewNote( info.startStr );
          // alert('selected ' + info.startStr + ' to ' + info.endStr);
        },
      });

      calendar.render();

      function sameViewCalendar() {
            var userSelection =  document.getElementsByClassName("tox-tinymce");
            // userSelection[0].style.display = "none";
            document.getElementById("calendar").style.visibility = "visible";
            calendar
      }
      function sameViewNote( value ) {
            var userSelection =  document.getElementsByClassName("tox-tinymce");
            // userSelection[0].style.display = "block";
            document.getElementById("calendar").style.visibility = "hidden";
            var json = {"type": "calendar", "value": value, "timeDefault": "", "time": ""};
            sameRapidCommand( json );
      }


  </script>


</body>
</html>
