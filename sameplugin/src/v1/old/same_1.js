/* funzione per pulire il codice HTML iniettato nella pagina - per potere evitare errori trusted con MEET o TEAMS*/
escapeHTMLPolicy = trustedTypes.createPolicy("forceInner", {
    createHTML: (to_escape) => to_escape
})

/****** PANEL DESIGN ************************************************/

var same_panel_recording_button = '<section class="main-controls">\
        <!--<canvas class="visualizer" height="60px"></canvas>-->\
        <div id="buttons">\
          <button id="same_screenshot_button" class="same_icon_style" title="Screenshot"> </button><hr>\
          <button id="same_record_button" class="same_record_button same_icon_style" title="Record"> </button>\
          <button id="same_stop_button" class="same_stop_button same_icon_style" title="Save"> </button>\
          <button id="same_cancel_button" class="same_cancel_button same_icon_style" title="Cancel"> </button>\
          <hr>\
        </div>\
      </section>\
      <section class="sound-clips">\
      </section>\
    </div>\
';


var same_panel_rapid_command = '<div id="same_rapid_command" style="float:left;">\
<button id="same_function_rapid_poi_short_button" class="same_resize_img same_icon_style" title="Shortcuts"></button><br>\
<button id="same_function_rapid_mak_short_button" class="same_resize_img same_icon_style" title="Shortcuts"></button><br>\
<button id="same_function_rapid_question_short_button" class="same_resize_img same_icon_style" title="Shortcuts"></button><br>\
<button id="same_function_rapid_rtc_short_button" class="same_resize_img same_icon_style" title="Shortcuts"></button><br>\
<button id="same_function_shortcut_short_button" class="same_resize_img same_icon_style" title="Shortcuts"> </button>\
</div>';
var same_panel_note = '<div id="same_note" style="display:none">' + same_panel_rapid_command + '<div id="same_note_text_div" style="float:left;"><textarea id="same_note_text"></textarea></div></div>'; //   <div contenteditable="true" id="same_note_text"><a href="" target="blank">zzzz</a></div>

var same_panel_shortcut = '\
<div id="same_shortcut" style="display:none">\
Quick commands: \
<button id="same_function_rapid_poi_button" class="same_buttom_img">Point of interest</button> \
<button id="same_function_rapid_mak_button" class="same_buttom_img">Make an appointment</button> \
<button id="same_function_rapid_question_button" class="same_buttom_img">Question?</button> \
<button id="same_function_rapid_rtc_button" class="same_buttom_img">Remember to call</button> \
<button id="same_function_rapid_insert_image_button">Test img</button> \
<button id="same_function_rapid_button">...</button> \
--- : --- \
</div>\
';

var same_panel_data_meeting = '\
<div id="same_data_meeting" style="display:none">\
<button id="same_function_agenda_data_button" class="same_buttom_img">Agenda</button> \
<button id="same_function_participant_list_button" class="same_buttom_img">Participant list</button> \
<button id="same_function_meeting_attachments_button" class="same_buttom_img">Attachments</button> \
<button id="same_function_meeting_data_button" class="same_buttom_img">Common date</button> \
</div>\
';

var same_panel_all_meeting = '\
<div id="same_all_meeting" style="display:none">\
<button id="same_function_all_meeting_calendar_button">Appointment calendar</button> \
<button id="same_function_all_meeting_new_button">New meeting</button> \
<button id="same_function_all_meeting_open_in_same_button">Open meeting in SAME</button> \
</div>\
';

var same_panel_setting = '\
<div id="same_setting" style="display:none">\
<div style="float:left;"><img id="img_setting_logo" src="https://extension.salesmeet.it/logo.png"> </div>\
<div style="float:left;">Settings: ---\</div>\
</div>\
';

var same_panel_common = '<div id="same_common" style="display:none"></div>';

var same_panel_recording = '<div id="same_recording" class="same_panel_style same_panel_style_border">' + same_panel_recording_button + '</div>';

// same_button_no_border
var same_panel_tools = '\
  <div id="same_tools" class="same_panel_style same_panel_style_border">\
  <button id="same_function_note_button">Note</button> \
  <button id="same_function_note_big_button" class="same_resize_img same_icon_style" title="Enlarge notes field"> </button>\
  <button id="same_function_note_small_button" class="same_resize_img same_icon_style" title="Secrease note field"> </button>\
  <button id="same_function_shortcut_button" class="same_resize_img same_icon_style" title="Shortcuts"> </button>\
  <hr>\
  <button id="same_function_data_meeting_button">Data meeting</button><hr>\
  <button id="same_function_data_report_meeting_button">Export / Edit plus</button><hr>\
  <button id="same_function_data_meeting_all_button">Template</button>\
  <button id="same_function_data_meeting_all_button">All meeting</button>\
  </div>\
';


// <button id="same_panel_edit_external_close" title="close">X</button>\
var same_panel_edit_external = '<div style="display:none;" id="same_panel_edit_external">\
<iframe src="" id="same_panel_edit_external_iframe"></iframe>\
</div>';


var same_panel_operation = '<div id="same_panel" class="same_panel_style same_panel_style_border">' + same_panel_shortcut + same_panel_note + same_panel_edit_external + same_panel_setting + same_panel_data_meeting + same_panel_all_meeting + same_panel_common + '</div>';

var same_panel_info = '<div id="same_info" class="same_panel_style">\
<button id="same_function_stop_hour_button" style="display:none;">Stop timer</button>\
<button id="same_function_start_short_hour_button" style="display:none;">Start timer</button>\
<button id="same_function_clear_hour_button" style="display:none;">Clear</button>\
<button id="same_function_start_hour_button">Start meeting</button>\
<hr>\
<div id="same_count_hour"><label id="same_minutes">00</label>:<label id="same_seconds">00</label></div>\
<hr>\
<button id="same_function_icon_button" class="same_icon_style" title="Zoom out"></button>\
<button id="same_function_top_button" class="same_icon_style" title="Position top"></button>\
<button id="same_function_bottom_button" class="same_icon_style" title="Position bottom"></button>\
<button id="same_function_setting_button" class="same_icon_style" title="Setting"></button>\
</div>';

/****** PANEL INIT  ************************************************/

/* Inizializza SAME creando l'immagine drag come primo step per il cliente */
function sameInit() {
    var same_init = '<img id="same_init_img" alt="Open" src="https://extension.salesmeet.it/logo.png"><div id="same_initheader">Click here to move</div>';
    var same_elemDiv = document.createElement('div');
    same_elemDiv.id = "same_init";
    same_elemDiv.innerHTML = escapeHTMLPolicy.createHTML(same_init);
    document.body.appendChild(same_elemDiv);
    sameClickCommon( "same_init_img" , sameInitHidden );
    sameDragElement(document.getElementById("same_init"));
}
/* Nasconde immagine SAME e apre il pannello di lavoro */
function sameInitHidden() {
    sameDisplayCommon("same_init","none");
    sameDisplayCommon("same_panel_base","block");
}
/* Nasconde il pannello di lavoro e apre immagine SAME */
function sameInitShow() {
    sameDisplayCommon("same_init","block");
    sameDisplayCommon("same_panel_base","none");
}
/* Inizializza il pannello di lavoro */
function sameInitPanel() {
    var same_elemDiv = document.createElement('div');
    same_elemDiv.id = "same_panel_base";
    same_elemDiv.innerHTML = escapeHTMLPolicy.createHTML(same_panel_recording + same_panel_tools + same_panel_operation + same_panel_info);
    document.body.appendChild(same_elemDiv);
    const myTimeout = setTimeout(sameChangePanelDataMeeting, 500);
}
/* funzioni per rendere l'immagine SAME draggabile */
function sameDragElement(elmnt) {
  var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
  if (document.getElementById(elmnt.id + "header")) {
    document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
  } else {
    elmnt.onmousedown = dragMouseDown;
  }
  function dragMouseDown(e) {
    e = e || window.event;
    e.preventDefault();
    pos3 = e.clientX;
    pos4 = e.clientY;
    document.onmouseup = closeDragElement;
    document.onmousemove = elementDrag;
  }
  function elementDrag(e) {
    e = e || window.event;
    e.preventDefault();
    pos1 = pos3 - e.clientX;
    pos2 = pos4 - e.clientY;
    pos3 = e.clientX;
    pos4 = e.clientY;
    elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
    elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
  }
  function closeDragElement() {
    document.onmouseup = null;
    document.onmousemove = null;
  }
}
/****** PANEL Note  ************************************************/

/* ritorna il valore contenuto nello WYSIWYG HTML */
function sameGetNoteValue() {
  return tinyMCE.activeEditor.getContent();
  // return document.getElementById("same_note_text").innerHTML;
}
/* scrive il valore nello WYSIWYG HTML */
function sameSetNoteValue( value ) {
  tinyMCE.activeEditor.setContent( escapeHTMLPolicy.createHTML(value) );
  // tinyMCE.activeEditor.setContent( escapeHTMLPolicy.createHTML( tinyMCE.activeEditor.getContent() + "sssssssssss") );
  // document.getElementById("same_note_text").innerHTML = escapeHTMLPolicy.createHTML(value);
}


var sameCharCodeBefore = "";
function sameNoteCheckInput(keyPressed){
    // console.log(sameCharCodeBefore + " _ " + keyPressed.charCode);
    // 64 = @      13 = a capo       32 = spazio       35 = #
    if  ( ( (keyPressed.charCode == 64) && (sameCharCodeBefore == 13) ) ||
          ( (keyPressed.charCode == 64) && (sameCharCodeBefore == 32) ) ||
          ( (keyPressed.charCode == 64) && (sameCharCodeBefore == "") )
        ){
        sameGetParticipantList();
    } /* else if  ( ( (keyPressed.charCode == 35) && (sameCharCodeBefore == 13) ) ||
               ( (keyPressed.charCode == 35) && (sameCharCodeBefore == 32) ) ||
               ( (keyPressed.charCode == 35) && (sameCharCodeBefore == "") )
        ){
        sameGetAgenda();
    }
    */
    // a capo
    if(keyPressed.charCode == 13 ){
        // document.getElementById("same_note_text").value = document.getElementById("same_note_text").value + same_getTimeNote();
        sameSetNoteValue( sameGetNoteValue() + same_getTimeNote() )
        // sameNoteTextFocus();
    }
    sameCharCodeBefore = keyPressed.charCode;
}

function sameNoteTextFocus() {
      var element = document.getElementById("same_note_text");
      // element.focus();
      // element.setSelectionRange(element.value.length,element.value.length);
}

function same_getTimeNote() {
   if (same_timer_flag) {
      return sameACapoCharacter + "[" + same_getTime() + "]";
   }
   return "";
}
function same_getTimeShortcut() {
    var temp = same_getTimeNote();
    if (temp==""){
        return "";
    }
    return same_getTimeNote() + sameACapoCharacter;
}

function sameNoteBig() {
      sameChangePanelNote();
      sameNoteBigCommon();
}
function sameNoteBigCommon() {
      var userSelection = document.getElementsByClassName("tox-tinymce");
      //element = document.getElementById("same_note_text");
      if (same_position_bottom) {
          userSelection[0].classList.add("same_note_text_big_bottom");
          //element.classList.add("same_note_text_big_bottom");
      } else {
          userSelection[0].classList.add("same_note_text_big_top");
          //element.classList.add("same_note_text_big_top");
      }
}
function sameNoteSmall() {
      sameChangePanelNote();
      var userSelection = document.getElementsByClassName("tox-tinymce");
      userSelection[0].classList.remove("same_note_text_big_bottom");
      userSelection[0].classList.remove("same_note_text_big_top");
      // element = document.getElementById("same_note_text");
      // element.classList.remove("same_note_text_big_bottom");
      // element.classList.remove("same_note_text_big_top");
}

/****** PANEL START & HOUR  ************************************************/

var same_minutesLabel = "";
var same_secondsLabel = "";
var same_totalSeconds = 0;

function same_getTime() {
   return same_minutesLabel.innerHTML + ":" + same_secondsLabel.innerHTML;
}
function same_setTime() {
  ++same_totalSeconds;
  same_secondsLabel.innerHTML = escapeHTMLPolicy.createHTML(same_pad(same_totalSeconds % 60));
  same_minutesLabel.innerHTML = escapeHTMLPolicy.createHTML(same_pad(parseInt(same_totalSeconds / 60)));
}
function same_pad(val) {
  var valString = val + "";
  if (valString.length < 2) {
    return "0" + valString;
  } else {
    return valString;
  }
}
var same_timer;
var same_timer_flag = false;
function sameStartHour() {
    same_minutesLabel = document.getElementById("same_minutes");
    same_secondsLabel = document.getElementById("same_seconds");
    same_timer_flag = true;
    same_timer = setInterval(same_setTime, 1000);
    sameDisplayCommon("same_function_start_hour_button","none");
    sameDisplayCommon("same_function_start_short_hour_button","none");
    sameDisplayCommon("same_function_stop_hour_button","block");
    sameDisplayCommon("same_function_clear_hour_button","block");
    samePostAPI("","sameStartHour");
}
function sameStopHour() {
    same_timer_flag = false;
    sameDisplayCommon("same_function_stop_hour_button","none");
    sameDisplayCommon("same_function_start_short_hour_button","block");
    clearInterval(same_timer);
    samePostAPI("","sameStopHour");
}
function sameClearHourAsk() {
    var temp = 'Do you want to reset timer?\
    <button id="same_function_clear_yes">YES</button>\
    <button id="same_function_clear_no">NO</button>\
    ';
    sameCommonBlock( temp );
    sameClickCommon( "same_function_clear_yes" , sameClearTimerYes );
    sameClickCommon( "same_function_clear_no" , sameClearTimerNo );
}
function sameClearTimerYes() {
    sameClearHour();
    sameCommonBlock( "" );
}
function sameClearTimerNo() {
    sameCommonBlock( "" );
}
function sameClearHour() {
    clearInterval(same_timer);
    same_totalSeconds = 0;
    same_secondsLabel.innerHTML = escapeHTMLPolicy.createHTML("00");
    same_minutesLabel.innerHTML =  escapeHTMLPolicy.createHTML("00");
    sameDisplayCommon("same_function_start_hour_button","block");
    sameDisplayCommon("same_function_start_short_hour_button","none");
    sameDisplayCommon("same_function_stop_hour_button","none");
    sameDisplayCommon("same_function_clear_hour_button","none");
    samePostAPI("","sameClearHour");
}

/****** PANEL FUNCTION  ************************************************/

function sameChangePanel(note,shortcut,setting,common,datameeting,allmeeting) {

      sameSelectedButtoCommon( "same_function_note_button" , note );
      sameDisplayCommon("same_note",note);

      sameSelectedButtoCommon( "same_function_shortcut_button" , shortcut );
      sameDisplayCommon("same_shortcut",shortcut);

      sameSelectedButtoCommon( "same_function_setting_button" , setting );
      sameDisplayCommon("same_setting",setting);

      sameSelectedButtoCommon( "same_function_data_meeting_button" , datameeting );
      sameDisplayCommon("same_data_meeting",datameeting);

      sameSelectedButtoCommon( "same_function_data_meeting_all_button" , allmeeting );
      sameDisplayCommon("same_all_meeting",allmeeting);

      sameDisplayCommon("same_common",common);

}
function sameSelectedButtoCommon( id_element , display ) {
      element = document.getElementById(id_element);
      if (display=="none") {
        element.classList.remove("same_panel_bottone_active");
      } else {
        element.classList.add("same_panel_bottone_active");
      }
}


var tinymceflag = false;
function sameChangePanelNote() {

      if (tinymceflag==false) {

          sameInitTinyMCE();
          tinymce.init({
            selector: '#same_note_text',
            height: 133,
            menubar: false,
            toolbar: 'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent | backcolor forecolor blockquote styleselect | selectall removeformat | undo redo',
            setup : function(ed) {
                ed.on("keypress", function(keypress){
                    sameNoteCheckInput(keypress);
                });
                ed.on("mouseout", function(){
                    samePostAPINote();
                });
           }
          });

          sameNoteBigCommon();
          tinymceflag = true;
      }

      sameChangePanel("block","none","none","none","none","none");
}
function sameChangePanelShortcut() {
      sameChangePanel("none","block","none","none","none","none");
}
function sameChangePanelSetting() {
      sameChangePanel("none","none","block","none","none","none");
}
function sameChangePanelDataMeeting() {
      sameChangePanel("none","none","none","none","block","none");
}
function sameChangePanelAllMeeting() {
      sameChangePanel("none","none","none","none","none","block");
}
function sameChangePanelCommon() {
      sameChangePanel("none","none","none","block","none","none");
}

function sameReplaceCharacters( value ) {
      return value.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g,'_');
}


/****** PANEL FUNCTION shortcut ************************************************/

var sameACapoCharacter = "";
function sameRapidPoi() {
      sameRapidCommand(1,"Point of interest","sameRapidPoi",sameACapoCharacter);
}
function sameRapidMak() {
      sameRapidCommand(1,"Make an appointment","sameRapidMak",sameACapoCharacter);
}
function sameRapidQuestion() {
      sameRapidCommand(1,"Question?","sameRapidCommand",sameACapoCharacter);
}
function sameRapidRtc() {
      sameRapidCommand(1,"Remember to call","sameRapidCommand",sameACapoCharacter);
}

function sameRapidCommand(time, value, type, start ) {

      var text = sameGetNoteValue(); // document.getElementById("same_note_text").value;
      // alert(document.getElementById("same_note_text").value);
      try {
        // alert(tinyMCE.activeEditor.getContent());
      } catch {  }
      var char_i = "[ ";
      var char_e = " ]";

      if (type == "sameGetParticipantList") {
          char_i = "user@";
          char_e = "";
          // per eliminare la @ dal testo
          // text = text.substring(0 , text.length - 1 );
      }
      else if (type == "sameGetAgenda") { char_i = "@agenda@"; char_e = ""; }
      else if (type == "sameGetAttachments") { char_i = "@link@"; char_e = ""; }
      else if (type == "sameGetDataMeeting") { char_i = "@meeting@"; char_e = ""; }

      if (time==1) { time = same_getTimeShortcut(); } else { time = ""; }

      /*
      var ed = tinyMCE.get('same_note_text');
      // console.log(ed);
      var range = ed.selection.getNode();
      console.log(range);
      console.log("-----------------");
      var startOffset = ed.selection.getRng().startOffset;
      console.log(startOffset);
      */

      var el = tinymce.activeEditor.dom.create('spam', {}, time + char_i + value + char_e);
      tinymce.activeEditor.selection.setNode( el );

      /*
      tinymce.activeEditor.selection.setCursorLocation(range,startOffset)
      var bm = tinymce.activeEditor.selection.getBookmark();
      console.log(bm);
      // Restore the selection bookmark
      tinymce.activeEditor.selection.moveToBookmark( bm );
      */

      // document.getElementById("same_note_text").value = text + start + time + char_i + value + char_e;
      // sameSetNoteValue( text + start + time + char_i + value + char_e );
      sameChangePanelNote();
      sameNoteTextFocus();
      samePostAPI(value,type);
}



/****** PANEL FUNCTION ALL MEETING ************************************************/

function sameAllMeetingCalendar( value ) {
    sameOpenWindowCommon( "https://sales-66641.firebaseapp.com/main/home" );
}

/****** PANEL FUNCTION COMMON ************************************************/

function sameCommonBlock( value ) {
      document.getElementById("same_common").innerHTML = escapeHTMLPolicy.createHTML(value);
      sameChangePanelCommon();
}
//

function sameAddValueInNote( value ){
    sameRapidCommand( 0, this.getAttribute('data-value') , this.getAttribute('data-type'), " ");
}

function sameCommonBlockApi( value, type ) {
      var myArr = JSON.parse(value);
      var myItems = myArr.items;
      var out = "";
      var i;
      for(i = 0; i < myItems.length; i++) {
        if (myItems[i].type == 'checkbox') {
            if (myItems[i].value == '1') { var checked = "checked"; } else { var checked = ""; }
            out += "<input type='checkbox' " + checked + " id='" + myItems[i].id + "'>";
        }
        if (myItems[i].type == 'link') {
            out += '<a href="' + myItems[i].value + '" target="_blank">' + myItems[i].description + '</a>';
        } else {
            out += myItems[i].description;
        }
        out += ' <button data-object="' + myItems[i].type + '" data-type="' + type + '" data-value="' + sameReplaceCharacters( myItems[i].description ) + '" class="sameAddValueInNote same_resize_small_img same_icon_style" title="Add note"></button>';
        out += "<br>";
      }
      if (myArr.edit!="") {
        out = '\
          <div id="same_data_meeting_edit">\
          <button data-url="' + myArr.edit + '" id="same_function_edit" class="same_icon_style" title="edit"></button>\
          <button data-url="' + myArr.edit + '" id="same_function_check" class="same_icon_style" title="Check"></button>\
          </div>\
          <div id="same_data_meeting_body">' + out + '</div>\
        ';
        document.getElementById("same_common").innerHTML = escapeHTMLPolicy.createHTML(out);
        sameClickCommon( "same_function_edit" , sameFunctionEditOpen );
        sameClickCommon( "same_function_check" , sameInProgress );
      } else {
        out = '<div style="float:left;" id="same_data_meeting_body">' + out + '</div>';
        document.getElementById("same_common").innerHTML = escapeHTMLPolicy.createHTML(out);
      }
      sameClickCommonClass( "sameAddValueInNote" , sameAddValueInNote );
      sameChangePanelCommon();
}
function sameGetAPI(url,type) {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               sameCommonBlockApi( this.responseText, type );
           }
      };
      xhttp.open("GET", url, true);
      xhttp.send();
}
function samePostAPI(value,action) {
      var data = new FormData();
      data.append('value', value);
      data.append('action', action);
      data.append('time', same_getTime());
      samePostAPICommon('https://extension.salesmeet.it/api/v1/postaction.php',data);
}
function samePostAPINote() {
      samePostAPINoteCommon( sameGetNoteValue() );
}
function samePostAPINoteCommon( value ) {
      var data = new FormData();
      data.append('value', value );
      samePostAPICommon('https://extension.salesmeet.it/api/v1/postnote.php',data);
}
function samePostAPIRecord( url ) {
      var data = new FormData();
      data.append('file', url );
      samePostAPICommon('https://extension.salesmeet.it/api/v1/postrecord.php',data);
}

function sameFunctionInsertImage() {

  var temp = sameGetNoteValue();
  sameSetNoteValue( temp + '<img src="https://extension.salesmeet.it/img/position-icon.png">');

}

function sameCreateFile( url ) {
    var temp = '<form method="POST" enctype="multipart/form-data" action="https://extension.salesmeet.it/api/v1/postrecord.php">\
    <input type="file" name="file">\
    <button type="submit" role="button">Upload File</button>\
    </form>';
    document.getElementById("same_common").innerHTML = escapeHTMLPolicy.createHTML(temp);
    sameChangePanelCommon();
}

function samePostAPICommon(url,data) {
      var xhr = new XMLHttpRequest();
      xhr.open('POST', url, true);
      xhr.onload = function () {
          // console.log(this.responseText);
      };
      xhr.send(data);
}
function sameInProgress(url) {
    sameCommonBlock("Section in progress ...");
}
function sameOpenWindowCommon( value ) {
    window.open(value);
}


function sameDisplayCommon( id , value ) {
  document.getElementById(id).style.display = value;
}
function sameClickCommon( id , name_funcition ) {
    document.getElementById(id).addEventListener("click", name_funcition);
}
function sameClickCommonClass( id , name_funcition ) {
    var userSelection =  document.getElementsByClassName(id); //.addEventListener("click", name_funcition);
    for(var i = 0; i < userSelection.length; i++) {
      (function(index) {
        userSelection[index].addEventListener("click", name_funcition);
      })(i);
    }
}

/****** PANEL FUNCTION EDIT ************************************************/

function sameFunctionEditOpen() {
    sameFunctionOpenCommon(document.getElementById("same_function_edit").getAttribute('data-url'));
}
function sameFunctionOpenReport() {
    if (tinymceflag==false) {
      sameChangePanelNote();
    } else {
      samePostAPINote();
    }
    sameFunctionOpenCommon("https://extension.salesmeet.it/api/v1/getreport.php");
    // window.open("https://extension.salesmeet.it/api/v1/getreport.php");
}
function sameFunctionCloseReport() {
    alert("prova");
}
function sameFunctionOpenCommon(url) {

    var element = document.getElementById("same_panel_edit_external");
    if (same_position_bottom) {
         element.classList.add("same_panel_edit_external_bottom");
         element.classList.remove("same_panel_edit_external_top");
    } else {
         element.classList.add("same_panel_edit_external_top");
         element.classList.remove("same_panel_edit_external_bottom");
    }
    sameDisplayCommon( "same_panel_edit_external","block");
    document.getElementById("same_panel_edit_external_iframe").src = url;
    sameClickCommon( "same_panel_edit_external_close" );
}
function sameFunctionEditClose() {
    sameDisplayCommon( "same_panel_edit_external","none");
}

/****** PANEL FUNCTION CALL API ************************************************/

function sameGetParticipantList() {
    sameGetAPI("https://extension.salesmeet.it/api/v1/getlistuser.php","sameGetParticipantList");
    samePostAPI("","sameGetParticipantList");
}
function sameGetDataMeeting() {
    sameGetAPI("https://extension.salesmeet.it/api/v1/getdatameeting.php","sameGetDataMeeting");
    samePostAPI("","sameGetDataMeeting");
}
function sameGetAgenda() {
    sameGetAPI("https://extension.salesmeet.it/api/v1/getagenda.php","sameGetAgenda");
    samePostAPI("","sameGetAgenda");
}
function sameGetAttachments() {
    sameGetAPI("https://extension.salesmeet.it/api/v1/getattachments.php","sameGetAttachments");
    samePostAPI("","sameGetAttachments");
}



/****** PANEL FUNCTION SETTING ************************************************/

var same_position_bottom = true;
function sameMovePanelTop() {
      same_position_bottom = false;
      document.getElementById("same_panel_base").style.top = "0px";
      document.getElementById("same_panel_base").style.bottom = "auto";
}
function sameMovePanelBottom() {
      same_position_bottom = true;
      document.getElementById("same_panel_base").style.top = "auto";
      document.getElementById("same_panel_base").style.bottom = "0px";
}


/****** RECORD FUNCTION  ************************************************/


function sameInitRecord() {

  const same_record_button = document.querySelector('.same_record_button');
  const same_stop_button = document.querySelector('.same_stop_button');
  const same_cancel_button = document.querySelector('.same_cancel_button');
  const soundClips = document.querySelector('.sound-clips');
  const canvas = document.querySelector('.visualizer');
  const mainSection = document.querySelector('.main-controls');

  // disable stop button while not recording
  same_stop_button.disabled = true;
  same_cancel_button.disabled = true;

  let audioCtx;

  // set up basic variables for app
  if (navigator.mediaDevices.getUserMedia) {

    console.log('getUserMedia supported.');

    let chunks = [];

    let onSuccess = function(stream) {

      const mediaRecorder = new MediaRecorder(stream);
      mediaRecorder.start

      /* visualize(stream); */

      same_record_button.onclick = function() {

        initSameExension();

        mediaRecorder.start();
        console.log(mediaRecorder.state);
        console.log("recorder started");
        same_record_button.style.background = "red";

        same_stop_button.disabled = false;
        same_cancel_button.disabled = false;
        same_record_button.disabled = true;
      }

      same_stop_button.onclick = function() {
        mediaRecorder.stop();
        console.log(mediaRecorder.state);
        console.log("recorder stopped");
        same_record_button.style.background = "";
        same_record_button.style.color = "";
        // mediaRecorder.requestData();

        same_stop_button.disabled = true;
        same_cancel_button.disabled = true;
        same_record_button.disabled = false;

        chrome.runtime.sendMessage("eakfjnpihbkoohjbelkfjcdlkdhfeadb","stopSame");

      }

      same_cancel_button.onclick = function() {
        mediaRecorder.stop();
        console.log(mediaRecorder.state);
        console.log("recorder stopped");
        same_record_button.style.background = "";
        same_record_button.style.color = "";
        // mediaRecorder.requestData();

        same_stop_button.disabled = true;
        same_cancel_button.disabled = true;
        same_record_button.disabled = false;

        chrome.runtime.sendMessage("eakfjnpihbkoohjbelkfjcdlkdhfeadb","cancelSame");

      }

      mediaRecorder.onstop = function(e) {
                console.log("data available after MediaRecorder.stop() called.");

        const clipName = prompt('Enter a name for your sound clip?','My unnamed clip');

        const clipContainer = document.createElement('article');
        const clipLabel = document.createElement('p');
        const audio = document.createElement('audio');
        const deleteButton = document.createElement('button');

        clipContainer.classList.add('clip');
        audio.setAttribute('controls', '');
        deleteButton.textContent = 'Delete';
        deleteButton.className = 'delete';

        if(clipName === null) {
          clipLabel.textContent = 'My unnamed clip';
        } else {
          clipLabel.textContent = clipName;
        }

        clipContainer.appendChild(audio);
        clipContainer.appendChild(clipLabel);
        clipContainer.appendChild(deleteButton);
        soundClips.appendChild(clipContainer);

        audio.controls = true;
        const blob = new Blob(chunks, { 'type' : 'audio/ogg; codecs=opus' });
        chunks = [];

        const audioURL = window.URL.createObjectURL(blob);

        // samePostAPIRecord( audioURL );
        //sameCreateFile( audioURL );
        audio.src = audioURL;

        console.log("audioURL: " + audioURL);
        console.log("recorder stopped");

        deleteButton.onclick = function(e) {
          let evtTgt = e.target;
          evtTgt.parentNode.parentNode.removeChild(evtTgt.parentNode);
        }

        clipLabel.onclick = function() {
          const existingName = clipLabel.textContent;
          const newClipName = prompt('Enter a new name for your sound clip?');
          if(newClipName === null) {
            clipLabel.textContent = existingName;
          } else {
            clipLabel.textContent = newClipName;
          }
        }
      }
      mediaRecorder.ondataavailable = function(e) {
        console.log("ondataavailable");
        chunks.push(e.data);
      }

    }

    let onError = function(err) {
      console.log('The following error occured: ' + err);
    }

    const constraints = { audio: true }
    navigator.mediaDevices.getUserMedia(constraints).then(onSuccess, onError);

  }

}

function initSameExension() {
    chrome.runtime.sendMessage("eakfjnpihbkoohjbelkfjcdlkdhfeadb","startSame");
}

function initSame() {

  sameInit();
  sameInitPanel();
  sameInitRecord();

  sameClickCommon( "same_function_note_big_button" , sameNoteBig );
  sameClickCommon( "same_function_note_small_button" , sameNoteSmall );

  sameClickCommon( "same_function_start_hour_button" , sameStartHour );
  sameClickCommon( "same_function_start_short_hour_button" , sameStartHour );
  sameClickCommon( "same_function_stop_hour_button" , sameStopHour );

  sameClickCommon( "same_function_clear_hour_button" , sameClearHourAsk );

  sameClickCommon( "same_function_note_button" , sameChangePanelNote );
  sameClickCommon( "same_function_shortcut_button" , sameChangePanelShortcut );
  sameClickCommon( "same_function_shortcut_short_button" , sameChangePanelShortcut );
  sameClickCommon( "same_function_setting_button" , sameChangePanelSetting );
  sameClickCommon( "same_function_data_meeting_button" , sameChangePanelDataMeeting );
  sameClickCommon( "same_function_data_meeting_all_button" , sameChangePanelAllMeeting );

  sameClickCommon( "same_function_rapid_poi_button" , sameRapidPoi );
  sameClickCommon( "same_function_rapid_mak_button" , sameRapidMak );
  sameClickCommon( "same_function_rapid_question_button" , sameRapidQuestion );
  sameClickCommon( "same_function_rapid_rtc_button" , sameRapidRtc );
  sameClickCommon( "same_function_rapid_poi_short_button" , sameRapidPoi );
  sameClickCommon( "same_function_rapid_mak_short_button" , sameRapidMak );
  sameClickCommon( "same_function_rapid_question_short_button" , sameRapidQuestion );
  sameClickCommon( "same_function_rapid_rtc_short_button" , sameRapidRtc );

  sameClickCommon( "same_function_participant_list_button" , sameGetParticipantList );
  sameClickCommon( "same_function_meeting_data_button" , sameGetDataMeeting );
  sameClickCommon( "same_function_agenda_data_button" , sameGetAgenda );
  sameClickCommon( "same_function_meeting_attachments_button" , sameGetAttachments);

  sameClickCommon( "same_function_all_meeting_calendar_button" , sameAllMeetingCalendar );
  sameClickCommon( "same_function_all_meeting_new_button" , sameAllMeetingCalendar );
  sameClickCommon( "same_function_all_meeting_open_in_same_button" , sameAllMeetingCalendar );

  // sameClickCommon( "same_panel_edit_external_close", sameFunctionEditClose );

  sameClickCommon( "same_function_top_button" , sameMovePanelTop );
  sameClickCommon( "same_function_bottom_button" , sameMovePanelBottom );
  sameClickCommon( "same_function_icon_button" , sameInitShow );

  sameClickCommon( "same_function_data_report_meeting_button" , sameFunctionOpenReport );

  sameClickCommon( "same_function_rapid_insert_image_button" , sameFunctionInsertImage );


  // document.getElementById("same_note_text").addEventListener("keypress", sameNoteCheckInput );
  // document.getElementById("tinymce").addEventListener("keypress", sameNoteCheckInput );



  document.getElementById("same_note_text").addEventListener("mouseout", samePostAPINote);
  window.onblur = function() {
     samePostAPINote();
  };

}


initSame();



/****** Chiamate dall'IFRAME  ************************************************/

if (window.addEventListener) {
    window.addEventListener("message", onMessage, false);
}
else if (window.attachEvent) {
    window.attachEvent("onmessage", onMessage, false);
}

function onMessage(event) {
    // Check sender origin to be trusted
    if (event.origin !== "https://extension.salesmeet.it") return;

    var data = event.data;

    if (typeof(window[data.func]) == "function") {
        window[data.func].call(null, data.message);
    }
}

// Function to be called from iframe
function sameSaveParentNote(message) {
    // console.log("cerco di salvare ....");
    samePostAPINoteCommon( message );
    var ed = tinymce.get('same_note_text');
    // console.log(ed);
    ed.setContent( message );
    // console.log("salvato ....");
    sameFunctionEditClose();
}
