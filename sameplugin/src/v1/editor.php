<?php //include("common/referer.php") ?>

<!DOCTYPE html>
<html>
<head>
  <script src="https://cdn.tiny.cloud/1/q8bxw8wqcr049zoy13p15fi50rgnjqfakkx9qrqnzmgt3wy4/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

  <link href='fullcalendar/lib/main.css' rel='stylesheet' />
  <script src='fullcalendar/lib/main.js'></script>
  <script src='fullcalendar/lib/locales-all.js'></script>

  <script src="https://unpkg.com/@popperjs/core@2"></script>
  <script src="https://unpkg.com/tippy.js@6"></script>

  <style>
    body {
      margin: 0px;
    }
  </style>
</head>
<body>
    <!--button id="myButton">My button</button>
    <script>
      // With the above scripts loaded, you can call `tippy()` with a CSS
      // selector and a `content` prop:
      tippy('#myButton', {
        content: 'My tooltip!',
        interactive: true,
      });
    </script -->

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
      // console.log( message );
      tinymce.activeEditor.setContent( message , {format: 'html'});
      tinyMCE.activeEditor.focus();
    }

    function sameChangeHeight() {
      window.focus();
      document.getElementById("same_note_text_iframe").focus();
      var height = document.documentElement.clientHeight
      if (height==0) {
          height = 500;
      }
      document.head.insertAdjacentHTML("beforeend", '<style> .same_note_text_iframe_dynamic { height: ' + height + 'px !important;}</style>')
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

          //console.log("sameRapidCommand:" + value.type);
          if (value.type=="rCalendar") {
              sameViewCalendar(value);
          } else {

              //console.log("sameRapidCommand:" + value);
              var char_i = "[ ";
              var char_e = " ]";

              var timeDefault = value.timeDefault;
              var hrs = ~~(timeDefault / 3600);
              var mins = ~~((timeDefault % 3600) / 60);
              var secs = ~~timeDefault % 60;
              if (hrs >0) {
                  var temp = sameFormatValue(hrs) + ":" + sameFormatValue(mins) + ":" + sameFormatValue(secs);
              } else {
                  var temp = sameFormatValue(mins) + ":" + sameFormatValue(secs);
              }
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

              // Prendo il valore
              var temp2 = tinymce.activeEditor.selection.getNode().innerHTML;
              // sostituisco il valore
              /*
              temp2 = temp2.replace("@@", "");  // 64
              temp2 = temp2.replace("##", "");  // 35
              */
              temp2 = temp2.replace("/@", "");  // 64
              temp2 = temp2.replace("/#", "");  // 35

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
          // valore per il trigger @@
          console.log(keyPressed.charCode + " __ " + sameCharCodeBefore );
          if ((keyPressed.charCode == 64) && (sameCharCodeBefore == 47)) {
          // if ((keyPressed.charCode == 64) && (sameCharCodeBefore == 64)) {
              sameDeleteTooltip();
              sameCall( "sameGetParticipantList", "" );
          // } else if ((keyPressed.charCode == 35) && (sameCharCodeBefore == 35)) {
          } else if ((keyPressed.charCode == 35) && (sameCharCodeBefore == 47)) {
              sameDeleteTooltip();
              sameCall( "sameGetAgenda", "" );
          }
          // spazio ...
          if ( keyPressed.charCode == 32) {
              sameWord = "";
          } else {
              sameWord += keyPressed.key;
          }

          if (keyPressed.charCode == 47) {
          // if ((keyPressed.charCode == 47) && (sameCharCodeBefore == 47)) {
              sameCreateTooltip();
          }

          sameCharCodeBefore = keyPressed.charCode;

          // console.log("sameWord: " + sameWord);
          if (sameWord.length > 2) {
            sameDeleteTooltip();
            for(i = 0; i < same_shortcut_list.length; i++) {
                let result = sameWord.includes( same_shortcut_list[i].shortcut );
                if (result) {
                // if (sameWord==same_shortcut_list[i].shortcut) {
                    sameDeleteTooltip();
                    sameWord = "";
                    var temp = '{"value":"' + same_shortcut_list[i].value + '","shortcut":"' + same_shortcut_list[i].shortcut + '","type":"' + same_shortcut_list[i].call + '"}';
                    sameCall( "sameEditorRapidCommad", temp );
                }
            }
          }

    }

    var tooltipid = null;
    function sameCreateTooltip() {

      sameDeleteTooltip();

      const iframe = document.getElementById("same_note_text_iframe_ifr");
      const iWindow = iframe.contentWindow;
      const iDocument = iWindow.document;

      const currentDate = new Date();
      const timestamp = currentDate.getTime();
      tooltipid = timestamp;

      var temp2 = tinymce.activeEditor.selection.getNode().innerHTML;
      tinymce.activeEditor.selection.getNode().innerHTML = "";
      var el = tinymce.activeEditor.dom.create('spam', {}, temp2 + " <label class='tooltipshortcut' id='" + timestamp + "'></label>");
      tinymce.activeEditor.selection.setNode( el );

      // tinymce.activeEditor.selection.getNode().setAttribute("id", "prova" + timestamp);
      // tinymce.activeEditor.selection.getNode().setAttribute("style", "background-color: #ff00ff;");
      // console.log(tinymce.activeEditor.selection.getNode());

      var stylea = "cursor: pointer;";
      var valori = "<div style='max-height: 180px; overflow: auto; padding: 10px; border: 2px solid #000; background: #eae5e5;'>";
      valori += "<a style='" + stylea + "' href='#' onclick='alert();'>/@</a>  -  Partecipant<br>";
      valori += "<a style='" + stylea + "' href='#' onclick='alert();'>/#</a>  -  Agenda<br>";
      for(i = 0; i < same_shortcut_list.length; i++) {
          valori += "<a style='" + stylea + "' href='#' onclick='alert();'>" + same_shortcut_list[i].shortcut + "</a>  -  " + same_shortcut_list[i].value + "<br>";
      }
      valori += "</div>";

      tooltipid = tippy( iDocument.getElementById( timestamp ), {
          content: valori,
          animation: 'scale',
          allowHTML: true,
          placement: 'right',
          offset: [0, 30],
          arrow: false,
          interactive: true,
      });
      tooltipid.show();
      sameCharCodeBefore = "";

    }

    function sameDeleteTooltip() {
        if (tooltipid === undefined || tooltipid === null) {
        } else {
            tooltipid.hide();
            tooltipid.destroy();
        }
    }

    function sameKeydown( keyDown ) {
        if (keyDown.key=="Enter") {
            sameDeleteTooltip();
            sameWord = "";
        } else if (keyDown.key=="Backspace")  {
            sameDeleteTooltip();
            sameWord = sameWord.substring(0, sameWord.length - 1);;
        } else if (keyDown.key==" ") {
            sameDeleteTooltip();
        }
    }

    function sameCall( value , message ) {
      window.parent.postMessage({
          'func': value,
          'message': message
      }, "*");
    }

    function sameFormatValue( value ) {
      if ( value < 10 ) {
          return "0" + value;
      }
      return value;
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
            /*
            ed.on("focus", function(){
                sameChangeHeight();
            });
            */
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
    window.addEventListener('focus', sameChangeHeight);

  </script>


  <div id='calendar' style="visibility:hidden; position: absolute;
    top: 0px;
    width: 100%;
    z-index: 999999;
    padding: 10px;
    border: 2px solid #000;
    background: #eae5e5;"></div>

  <script>
      var calendarEl = document.getElementById('calendar');

      var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        buttonIcons: false, // show the prev/next text
        weekNumbers: true,
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        dayMaxEvents: true, // allow "more" link when too many events
        selectable: true,
        height: 480,
        dateClick: function(info) {
          // alert("dateClick");
        },
        select: function(info) {
          /*
          console.log(info.start.getDate());
          console.log(info.start.getFullYear());
          console.log(info.start.getMonth());
          console.log("_________");
          console.log(info.start.getHours());
          console.log(info.start.getMinutes());
          console.log(info);
          console.log("_________");
          */
          var data =  sameFormatValue(info.start.getDate()) + "-" + sameFormatValue(info.start.getMonth() + 1) + "-" + info.start.getFullYear();
          // console.log( info.startStr.length );
          if ( info.startStr.length > 10 ) {
            data = data + " " + sameFormatValue(info.start.getHours()) + ":" + sameFormatValue(info.start.getMinutes());
          }
          sameViewNote( data );

          // sameViewNote( info.startStr );
          // alert('selected ' + info.startStr + ' to ' + info.endStr);
        },
      });

      calendar.render();

      function sameViewCalendar() {
            document.getElementById("calendar").style.visibility = "visible";
            // document.getElementById("calendar").style.display = "block";
      }
      function sameViewNote( value ) {
            document.getElementById("calendar").style.visibility = "hidden";
            // document.getElementById("calendar").style.display = "none";
            var json = {"type": "calendar", "value": value, "timeDefault": "", "time": ""};
            sameRapidCommand( json );
      }

  </script>


</body>
</html>
