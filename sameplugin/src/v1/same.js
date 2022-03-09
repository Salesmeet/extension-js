/* funzione per pulire il codice HTML iniettato nella pagina - per potere evitare errori trusted con MEET o TEAMS*/
escapeHTMLPolicy = trustedTypes.createPolicy("forceInner", {
    createHTML: (to_escape) => to_escape
})

var same_domain_api = "https://api.sameapp.net";
var same_domain = "https://plugin.sameapp.net";
var same_id_extension = "jinjngkjbcaedjmllefbghfodplfngeh";

function sameGetIdMeeting() { return "7EQPmfmJD5eahPCLNxwV"; }
function sameGetLanguage() { return "en"; }
function sameGetUser() { return "2"; }

/****** PANEL DESIGN ************************************************/
var same_panel_recording_button = '<section class="main-controls">\
        <!--<canvas class="visualizer" height="60px"></canvas>-->\
        <div id="buttons">\
          <button id="same_screenshot_button" class="same_icon_style" title="Screenshot"> </button><hr class="same_hidden">\
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
<button id="same_function_rapid_poi_short_button" class="same_resize_img same_icon_style" title="Shortcuts"></button><br class="same_hidden">\
<button id="same_function_rapid_mak_short_button" class="same_resize_img same_icon_style" title="Shortcuts"></button><br class="same_hidden">\
<button id="same_function_rapid_question_short_button" class="same_resize_img same_icon_style" title="Shortcuts"></button><br class="same_hidden">\
<button id="same_function_rapid_rtc_short_button" class="same_resize_img same_icon_style" title="Shortcuts"></button><br class="same_hidden">\
<button id="same_function_shortcut_short_button" class="same_resize_img same_icon_style" title="Shortcuts"> </button>\
</div>';
var same_panel_note = '<div id="same_note" style="display:none">' + same_panel_rapid_command + '<div id="same_note_text_div" style="float:left;"><iframe src="' + same_domain + '/v1/editor.php?idmeeting=' + sameGetIdMeeting() + '&lang=' + sameGetLanguage() + "&user=" + sameGetUser() + '" id="same_note_text_iframe"></iframe></div></div>'; //  <textarea id="same_note_text"></textarea> <div contenteditable="true" id="same_note_text"><a href="" target="blank">zzzz</a></div>

var same_panel_shortcut = '\
<div id="same_shortcut" style="display:none">\
<button id="same_function_rapid_poi_button" class="same_buttom_img">Point of interest</button> \
<button id="same_function_rapid_mak_button" class="same_buttom_img">Make an appointment</button> \
<button id="same_function_rapid_question_button" class="same_buttom_img">Question?</button> \
<button id="same_function_rapid_rtc_button" class="same_buttom_img">Remember to call</button> \
<button id="same_function_rapid_u_links_button" class="same_buttom_img">Useful links</button> \
<button id="same_function_rapid_button">...</button> \
--- : --- \
</div>\
';

var same_panel_data_meeting = '\
<div id="same_data_meeting" style="display:none">\
<button id="same_function_agenda_data_button" class="same_buttom_img">Agenda</button> \
<button id="same_function_participant_list_button" class="same_buttom_img">Participant list</button> \
<button id="same_function_meeting_attachments_button" class="same_buttom_img">Attachments</button> \
<button id="same_function_meeting_data_button" class="same_buttom_img">Summary</button> \
<button id="same_function_screenshot_button" class="same_buttom_img">Screenshot list</button> \
<button id="same_function_records_button" class="same_buttom_img">Records list</button> \
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
<div style="float:left;">Note shortcuts function: if you write ... <br> \
@@ -> add user from list <br> \
</div>\
</div>\
';

var same_panel_common = '<div id="same_common" style="display:none"></div>';

var same_panel_recording = '<div id="same_recording" class="same_panel_style same_panel_style_border">' + same_panel_recording_button + '</div>';

// same_button_no_border
var same_panel_tools = '\
  <div id="same_tools" class="same_panel_style same_panel_style_border">\
  <button id="same_function_note_button">Note</button> \
  <button id="same_function_note_big_button" class="same_resize_img same_icon_style same_hidden" title="Enlarge notes field"> </button>\
  <button id="same_function_note_small_button" class="same_resize_img same_icon_style same_hidden" title="Secrease note field"> </button>\
  <button id="same_function_shortcut_button" class="same_resize_img same_icon_style" title="Shortcuts"> </button>\
  <hr class="">\
  <button id="same_function_data_meeting_button">Data meeting</button><hr class="same_hidden">\
  <button id="same_function_data_report_meeting_button">Export / Edit plus</button><hr class="same_hidden">\
  <button id="same_function_data_meeting_template_button">Template</button>\
  <button id="same_function_data_meeting_all_button">All meeting</button>\
  </div>\
';

var same_panel_edit_external = '<div style="display:none;" id="same_panel_edit_external">\
<iframe src="" id="same_panel_edit_external_iframe"></iframe>\
</div>';

var same_panel_init_after_note = '<div style="display:none;" id="same_panel_init_after_note">\
Meeting already active. There are saved notes.<br><br> \
Do you want to proceed with the recovery? <br><br>\
<button id="same_function_open_note_version_button">Open list version</button>\
</div>';

var same_panel_operation = '<div id="same_panel" class="same_panel_style same_panel_style_border">' + same_panel_shortcut + same_panel_note + same_panel_edit_external + same_panel_setting + same_panel_data_meeting + same_panel_all_meeting + same_panel_common + same_panel_init_after_note + '</div>';

var same_panel_info = '<div id="same_info" class="same_panel_style">\
<button id="same_function_stop_hour_button" style="display:none;">Stop timer</button>\
<button id="same_function_start_short_hour_button" style="display:none;">Resume</button>\
<button id="same_function_clear_hour_button" style="display:none;">Clear</button>\
<button id="same_function_start_hour_button">Start timer</button>\
<hr>\
<div id="same_count_hour"><label id="same_minutes">00</label>:<label id="same_seconds">00</label></div>\
<hr>\
<button id="same_function_icon_button" class="same_icon_style" title="Zoom out"></button>\
<button id="same_function_top_button" class="same_icon_style" title="Position top"></button>\
<button id="same_function_bottom_button" class="same_icon_style" title="Position bottom"></button>\
<button id="same_function_right_button" class="same_icon_style" title="Position right"></button>\
<!--button id="same_function_setting_button" class="same_icon_style" title="Setting"></button-->\
</div>';

/****** PANEL INIT  ************************************************/

/* Inizializza SAME creando l'immagine drag come primo step per il cliente */
function sameInit() {
    var same_init = '<img id="same_init_img" alt="Open" src="' + same_domain + '/logo.png"><div id="same_initheader">Click here to move</div>';
    var same_elemDiv = document.createElement('div');
    same_elemDiv.id = "same_init";
    same_elemDiv.innerHTML = escapeHTMLPolicy.createHTML(same_init);
    // same_elemDiv.style = "background: #FFFFFF;bottom: 110px;position: absolute;width: 150px;height: 75px;z-index: 99990;border: 1px solid #000";
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

    // init per l'eventuale ritorno delle note ...
    sameGetAPI(same_domain_api + "/public/v1/meeting/init/" ,"sameGetAttachments", "sameInitAfter");

    // const myTimeout = setTimeout(sameChangePanelDataMeeting, 500);
    // const myTimeout = setTimeout(sameGetDataMeeting, 500);
}

/******* DA QUI CORRADO ******/
function sameInitAfter( data ) {
    var myArr = JSON.parse(data);
    if (myArr.init!="") {
        console.log("non init");
        sameDisplayCommon( "same_panel_init_after_note" , "block" );
    } else {
        console.log("init");
        myTimeout = setTimeout(sameGetDataMeeting, 200);
    }
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

/* scrive il valore nello WYSIWYG HTML */
function sameSetNoteValue( value ) {
  samePostMessageNote( value, "sameWrite" );
}

function sameGetIframeTiny()  {
    return document.getElementById("same_note_text_iframe");
}

/* ritorna il tempo da inserire correlato con le funzioni rapide */
function same_getTimeNote() {
   if (same_timer_flag) {
      return sameACapoCharacter + "[" + same_getTime() + "]";
   }
   return "";
}
/* ritorna il tempo da inserire correlato con le funzioni rapide */
function same_getTimeShortcut() {
    var temp = same_getTimeNote();
    if (temp==""){
        return "";
    }
    return same_getTimeNote() + sameACapoCharacter;
}
/* ingrandisce WYSIWYG HTML */
function sameNoteBig() {
      sameChangePanelNote();
      sameNoteBigCommon();
}
/* ingrandisce WYSIWYG HTML */
function sameNoteBigCommon() {
      sameNoteChangeHeight();
      element = document.getElementById("same_note_text_iframe");
      if (same_position_bottom) {
          element.classList.add("same_note_text_big_bottom");
      } else {
          element.classList.add("same_note_text_big_top");
      }
}
function sameNoteChangeHeight() {
      samePostMessageNote( "", "changeHeight" );
}

function samePostMessageNote( value, action ) {
      sameGetIframeTiny().contentWindow.postMessage( {"value":value,"action":action} , '*');
}

/* rimpicciolisce WYSIWYG HTML */
function sameNoteSmall() {
      sameChangePanelNote();
      sameNoteChangeHeight();
      element = document.getElementById("same_note_text_iframe");
      element.classList.remove("same_note_text_big_bottom");
      element.classList.remove("same_note_text_big_top");
}


/****** TIMER DEFAULT  ************************************************/
/****** PANEL START & HOUR  ************************************************/

var same_minutesLabel = "";
var same_secondsLabel = "";
var same_totalSeconds = 0;

var sameDefaultMinutes = "";
var sameDefaultSeconds = "";
var sameDefaulTotalSeconds = 0;
function sameStartHourDefault() {
     const d = new Date();
     var temp = d.getFullYear() + "-" + d.getMonth() + "-" + d.getDate() + "-" + d.getHours() + "-" + d.getMinutes() + "-" + d.getSeconds();
     samePostAPI(temp,"sameStartHourDefault")
     setInterval(sameStartHourDefaultSetTime, 1000);
}
function sameStartHourDefaultSetTime() {
    ++sameDefaulTotalSeconds;
}
sameStartHourDefault();

function same_getTime() {
   try {
      if (same_minutesLabel.innerHTML!==undefined) {
        return same_minutesLabel.innerHTML + ":" + same_secondsLabel.innerHTML;
      } else {
        return "";
      }
   } catch (error) {
      return "";
   }

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
    samePostAPI(same_totalSeconds,"sameStartHour");
    same_minutesLabel = document.getElementById("same_minutes");
    same_secondsLabel = document.getElementById("same_seconds");
    same_timer_flag = true;
    same_timer = setInterval(same_setTime, 1000);
    sameDisplayCommon("same_function_start_hour_button","none");
    sameDisplayCommon("same_function_start_short_hour_button","none");
    sameDisplayCommon("same_function_stop_hour_button","block");
    sameDisplayCommon("same_function_clear_hour_button","block");
}
function sameStopHour() {
    samePostAPI(same_totalSeconds,"sameStopHour");
    same_timer_flag = false;
    sameDisplayCommon("same_function_stop_hour_button","none");
    sameDisplayCommon("same_function_start_short_hour_button","block");
    clearInterval(same_timer);
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
    samePostAPI(same_totalSeconds,"sameClearHour");
    clearInterval(same_timer);
    same_totalSeconds = 0;
    same_secondsLabel.innerHTML = escapeHTMLPolicy.createHTML("00");
    same_minutesLabel.innerHTML =  escapeHTMLPolicy.createHTML("00");
    sameDisplayCommon("same_function_start_hour_button","block");
    sameDisplayCommon("same_function_start_short_hour_button","none");
    sameDisplayCommon("same_function_stop_hour_button","none");
    sameDisplayCommon("same_function_clear_hour_button","none");
}

/****** PANEL FUNCTION  ************************************************/

/* gestisce il cambio di visualizzazione dei pannelli */
function sameChangePanel(note,shortcut,setting,common,datameeting,allmeeting) {

      sameSelectedButtoCommon( "same_function_note_button" , note );
      sameDisplayCommon("same_note",note);

      sameSelectedButtoCommon( "same_function_shortcut_button" , shortcut );
      sameDisplayCommon("same_shortcut",shortcut);

      // sameSelectedButtoCommon( "same_function_setting_button" , setting );
      sameDisplayCommon("same_setting",setting);

      sameSelectedButtoCommon( "same_function_data_meeting_button" , datameeting );
      sameDisplayCommon("same_data_meeting",datameeting);

      sameSelectedButtoCommon( "same_function_data_meeting_all_button" , allmeeting );
      sameDisplayCommon("same_all_meeting",allmeeting);

      // pannello iniziale recupero note ... Sempre in none.
      sameDisplayCommon("same_panel_init_after_note","none");
      sameDisplayCommon("same_common",common);

}
/* gestisce il colore dei bottoni in base alla visualizzazione dei pannelli */
function sameSelectedButtoCommon( id_element , display ) {
      element = document.getElementById(id_element);
      if (display=="none") {
        element.classList.remove("same_panel_bottone_active");
      } else {
        element.classList.add("same_panel_bottone_active");
      }
}

/* attiva il pannello note creando WYSIWYG HTML */
var sameFlagInitNote = false;
function sameChangePanelNote() {
      if (sameFlagInitNote==false) {
          sameFlagInitNote = true;
          sameNoteBigCommon();
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

/****** PANEL FUNCTION comandi rapidi ************************************************/

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
function sameRapidUlinks() {
      sameRapidCommand(1,"Useful links","sameRapidCommand",sameACapoCharacter);
}

function sameRapidCommand(time, value, type, start ) {
      var char_i = "[ ";
      var char_e = " ]";
      if ((type == "sameGetParticipantList") || (type == "sameGetAgenda") || (type == "sameGetAttachments") || (type == "sameGetDataMeeting") ) {
        char_i = ""; char_e = "";
      }
      if (time==1) { time = same_getTimeShortcut(); } else { time = ""; }
      samePostMessageNote(  time + char_i + value + char_e , "sameRapidCommand" );
      sameChangePanelNote();
      samePostAPI(value,type);
}

/****** PANEL FUNCTION ALL MEETING ************************************************/

function sameAllMeetingCalendar( value ) {
    sameOpenWindowCommon( "https://my.sameapp.net/" );
}

/****** PANEL FUNCTION COMMON ************************************************/

/* centralizza la scrittura all'interno del pnnello common */
function sameCommonBlock( value ) {
      document.getElementById("same_common").innerHTML = escapeHTMLPolicy.createHTML(value);
      sameChangePanelCommon();
}

function sameReplaceCharacters( value ) {
      return value.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g,'_');
}
/* funzione per reintempreta la scrittura dei comandi rapidi */
function sameAddValueInNote( value ){
    sameRapidCommand( 0, this.getAttribute('data-value') , this.getAttribute('data-type'), " ");
}
/* funzione per cambiare il check dei checkbox */
function sameAddValueCheck( value ){
    var checked = 0;
    if (this.checked) { checked = 1; }
    var data = new FormData();
    data.append('id', this.id);
    data.append('checked', checked );
    data.append('value', checked );
    data.append('idmeeting', sameGetIdMeeting());
    data.append('second', sameDefaulTotalSeconds);
    data.append('secondmanual', same_totalSeconds);
    data.append('user', sameGetUser());
    data.append('action', "");
    samePostAPICommon( this.getAttribute('data-url') , data);
}

/* analisi e creazione dei blocchi per la sezione "data meeting" */
function sameCommonBlockApi( value, type ) {
      var myArr = JSON.parse(value);
      var myItems = myArr.items;
      var out = "";
      var i;
      var title = "";
      if (myArr.title!="") {
          title ='<b>' + myArr.title + '</b><br>';
      }
      for(i = 0; i < myItems.length; i++) {
        if (myItems[i].type == 'checkbox') {
            if (myItems[i].checked == '1') { var checked = "checked"; } else { var checked = ""; }
            out += "<input class='sameAddValueCheck' data-url='" + myArr.apiupdate + "' type='checkbox' " + checked + " id='" + myItems[i].id + "'>";
        }
        var description = "";
        if (myArr.viewdescription == "1") { description = myItems[i].description + ": "; }

        if (myItems[i].type == 'link') {
            out += '<a href="' + myItems[i].value + '" target="_blank">' + description + myItems[i].value + '</a>';
        } else if (myItems[i].type == 'record') {
           if (myItems[i].name!="") {
              out += '<a href="' + same_domain_api + myItems[i].directory + myItems[i].value  + '" target="_blank">' + myItems[i].name + ' (' + myItems[i].date + ')</a>';
           } else {
              out += '<a href="' + same_domain_api + myItems[i].directory + myItems[i].value  + '" target="_blank">' + myItems[i].value + ' (' + myItems[i].date + ')</a>';
           }
         } else if (myItems[i].type == 'screenshot') {
            if (myItems[i].name!="") {
               out += '<a href="' + same_domain_api + myItems[i].directory + myItems[i].value  + '" target="_blank">' + myItems[i].name + ' (' + myItems[i].date + ')</a>';
            } else {
               out += '<a href="' + same_domain_api + myItems[i].directory + myItems[i].value  + '" target="_blank">' + myItems[i].value + ' (' + myItems[i].date + ')</a>';
            }
        } else {
            out += description + myItems[i].value;
        }
        out += ' <button data-object="' + myItems[i].type + '" data-type="' + type + '" data-value="' + sameReplaceCharacters( myItems[i].value ) + '" class="sameAddValueInNote same_resize_small_img same_icon_style" title="Add note"></button>';
        out += "<br>";
      }
      if (myArr.edit!="") {
        out = '\
          <div id="same_data_meeting_edit">\
          <button data-type="' + myArr.edit + '" id="same_function_edit" class="same_icon_style" title="edit"></button>\
          </div>\
          <div id="same_data_meeting_body">' + title + out + '</div>\
        ';
        // <button data-url="' + myArr.edit + '" id="same_function_check" class="same_icon_style" title="Check"></button>\

        document.getElementById("same_common").innerHTML = escapeHTMLPolicy.createHTML(out);
        sameClickCommon( "same_function_edit" , sameFunctionEditOpen );

      } else {
        out = '<div style="float:left;" id="same_data_meeting_body">' + title + out + '</div>';
        document.getElementById("same_common").innerHTML = escapeHTMLPolicy.createHTML(out);
      }
      sameClickCommonClass( "sameAddValueInNote" , sameAddValueInNote , "click" );
      sameClickCommonClass( "sameAddValueCheck" , sameAddValueCheck , "click" );
      sameChangePanelCommon();
}

function sameGetAPI(url,type,action) {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               if (action=="sameInitAfter") {
                 sameInitAfter(this.responseText);
               } else {
                 sameCommonBlockApi( this.responseText, type );
               }
           }
      };
      xhttp.open("GET", url + sameGetIdMeeting() + "/" + sameGetLanguage() + "/" + sameGetUser() , true);
      xhttp.send();
}
function samePostAPI(value,action) {
      if (value==="") {
          console.log("Vuoto: " + action + " __ " + value);
      } else {
          // console.log("samePostAPI");
          var data = new FormData();
          data.append('value', value);
          data.append('action', action);
          data.append('second', sameDefaulTotalSeconds);
          data.append('secondmanual', same_totalSeconds);
          data.append('idmeeting', sameGetIdMeeting());
          data.append('lang', sameGetLanguage());
          data.append('user', sameGetUser());
          samePostAPICommon( same_domain_api + '/public/v1/action',data);
      }
}
/* salva i dati provenienti dallo WYSIWYG HTML */
function samePostAPINote() {
      samePostMessageNote( "", "saveNote" );
}

function samePostAPICommon(url,data) {
      var xhr = new XMLHttpRequest();
      xhr.open('POST', url, true);
      xhr.onload = function () {
          // console.log(this.responseText);
      };
      try {
        xhr.send(data);
      } catch (error) {
      }
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
      try {
        document.getElementById(id).addEventListener("click", name_funcition);
      } catch (error) {
      }
}
function sameClickCommonClass( id , name_funcition, action ) {
    var userSelection =  document.getElementsByClassName(id); //.addEventListener("click", name_funcition);
    for(var i = 0; i < userSelection.length; i++) {
      (function(index) {
        // console.log(index);
        userSelection[index].addEventListener( action , name_funcition);
      })(i);
    }
}

/****** PANEL FUNCTION TEMPLATE ************************************************/
function sameFunctionOpenTemplate() {
    samePostAPINote();
    sameChangePanelNote();
    sameFunctionOpenTemplateCommon( "" );
}
function sameFunctionOpenTemplateCommon( init ) {
    sameFunctionOpenCommon(same_domain + "/v1/gettemplate.php?idmeeting=" + sameGetIdMeeting() + "&init=" + init);
}

/****** PANEL FUNCTION EDIT ************************************************/
function sameFunctionEditOpen() {
    var type = document.getElementById("same_function_edit").getAttribute('data-type')
    sameFunctionOpenCommon(same_domain + "/v1/getmeeting.php?idmeeting=" + sameGetIdMeeting() + "&type=" + type + "&lang=" + sameGetLanguage() + "&user=" + sameGetUser() );
}
function sameFunctionOpenNoteVersion() {
    sameFunctionOpenCommon(same_domain + "/v1/getnoteversion.php?idmeeting=" + sameGetIdMeeting() + "&lang=" + sameGetLanguage() + "&user=" + sameGetUser() );
}
function sameFunctionOpenReport() {
    if (sameFlagInitNote==false) {
      sameChangePanelNote();
    } else {
      samePostAPINote();
    }
    sameFunctionOpenCommon(same_domain + "/v1/getreport.php?idmeeting=" + sameGetIdMeeting() );
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
    document.getElementById("same_panel_edit_external_iframe").src = "";
    sameDisplayCommon( "same_panel_edit_external","none");

}

/****** PANEL FUNCTION CALL API ************************************************/
function sameGetParticipantList() {
    // console.log("sameGetParticipantList");
    sameGetAPI(same_domain_api + "/public/v1/partecipants/" ,"sameGetParticipantList", "");
}
function sameGetDataMeeting() {
    sameGetAPI(same_domain_api + "/public/v1/meeting/" ,"sameGetDataMeeting", "");
}
function sameGetAgenda() {
    sameGetAPI(same_domain_api + "/public/v1/agenda/" ,"sameGetAgenda", "");
}
function sameGetAttachments() {
    sameGetAPI(same_domain_api + "/public/v1/attachements/" ,"sameGetAttachments", "");
}
function sameGetRecords() {
    sameGetAPI(same_domain_api + "/public/v1/record/all/" ,"sameGetRecords", "");
}
function sameGetScreenshot() {
    sameGetAPI(same_domain_api + "/public/v1/screenshot/all/" ,"sameGetScreenshot", "");
}



/****** PANEL FUNCTION SETTING ************************************************/

var same_position_bottom = true;
function sameMovePanelTop() {
      same_position_bottom = false;
      sameMovePanelDeleteRight();
      document.getElementById("same_panel_base").style.top = "0px";
      document.getElementById("same_panel_base").style.bottom = "auto";
      sameNoteSmall();
}
function sameMovePanelBottom() {
      same_position_bottom = true;
      sameNoteSmall();
      sameMovePanelDeleteRight();
      document.getElementById("same_panel_base").style.top = "auto";
      document.getElementById("same_panel_base").style.bottom = "0px";
}
function sameMovePanelRight() {
      document.getElementById("same_panel_base").classList.add("same_panel_base_right");
      document.getElementById("same_recording").classList.add("same_panel_right");
      document.getElementById("same_tools").classList.add("same_panel_right_tools");
      document.getElementById("same_panel").classList.add("same_panel_panel_right");
      document.getElementById("same_info").classList.add("same_panel_right");
      document.getElementById("same_common").classList.add("same_panel_panel_right");
      document.getElementById("same_note_text_iframe").classList.add("same_note_text_iframe_right");
      document.getElementById("same_panel_edit_external").classList.add("same_panel_edit_external_right");
      document.getElementById("same_rapid_command").classList.add("same_rapid_command_right");
      sameNoteBig();

      var hrselec =  document.getElementsByClassName("same_hidden");
      for(var i = 0; i < hrselec.length; i++) {
          hrselec[i].classList.add("same_hidden_right");
      }
}

function sameMovePanelDeleteRight() {
      document.getElementById("same_panel_base").classList.remove("same_panel_base_right");
      document.getElementById("same_recording").classList.remove("same_panel_right");
      document.getElementById("same_tools").classList.remove("same_panel_right_tools");
      document.getElementById("same_panel").classList.remove("same_panel_panel_right");
      document.getElementById("same_info").classList.remove("same_panel_right");
      document.getElementById("same_common").classList.remove("same_panel_panel_right");
      document.getElementById("same_note_text_iframe").classList.remove("same_note_text_iframe_right");
      document.getElementById("same_panel_edit_external").classList.remove("same_panel_edit_external_right");
      document.getElementById("same_rapid_command").classList.remove("same_rapid_command_right");

      var hrselec =  document.getElementsByClassName("same_hidden");
      for(var i = 0; i < hrselec.length; i++) {
          hrselec[i].classList.remove("same_hidden_right");
      }
}

/****** PANEL SEARCH ************************************************/

function sameLogin(str) {
  console.log("sameLogin");
  var url = "chrome-extension://jinjngkjbcaedjmllefbghfodplfngeh/options/options.html";
  url = "chrome-extension://eakfjnpihbkoohjbelkfjcdlkdhfeadb/options/options.html";
  windiw.open(url);
}

/****** INIT  ************************************************/

function initSame() {

  sameInit();
  sameInitPanel();

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
  sameClickCommon( "same_function_rapid_u_links_button" , sameRapidUlinks);

  sameClickCommon( "same_function_rapid_poi_short_button" , sameRapidPoi );
  sameClickCommon( "same_function_rapid_mak_short_button" , sameRapidMak );
  sameClickCommon( "same_function_rapid_question_short_button" , sameRapidQuestion );
  sameClickCommon( "same_function_rapid_rtc_short_button" , sameRapidRtc );

  sameClickCommon( "same_function_participant_list_button" , sameGetParticipantList );
  sameClickCommon( "same_function_meeting_data_button" , sameGetDataMeeting );
  sameClickCommon( "same_function_agenda_data_button" , sameGetAgenda );
  sameClickCommon( "same_function_meeting_attachments_button" , sameGetAttachments);
  sameClickCommon( "same_function_records_button" , sameGetRecords );
  sameClickCommon( "same_function_screenshot_button" , sameGetScreenshot );



  sameClickCommon( "same_function_all_meeting_calendar_button" , sameAllMeetingCalendar );
  sameClickCommon( "same_function_all_meeting_new_button" , sameAllMeetingCalendar );
  sameClickCommon( "same_function_all_meeting_open_in_same_button" , sameAllMeetingCalendar );

  sameClickCommon( "same_function_top_button" , sameMovePanelTop );
  sameClickCommon( "same_function_bottom_button" , sameMovePanelBottom );
  sameClickCommon( "same_function_right_button" , sameMovePanelRight );
  sameClickCommon( "same_function_icon_button" , sameInitShow );

  sameClickCommon( "same_function_data_report_meeting_button" , sameFunctionOpenReport );

  sameClickCommon( "same_function_data_meeting_template_button" , sameFunctionOpenTemplate );

  sameClickCommon( "same_screenshot_button" , initScreenshotsSameExension )
  sameClickCommon( "same_function_open_note_version_button" , sameFunctionOpenNoteVersion )

  document.getElementById("same_note_text_iframe").addEventListener("mouseout", samePostAPINote);
  window.onblur = function() {
     samePostAPINote();
  };

}

/****** Chiamate dall'IFRAME  ************************************************/

if (window.addEventListener) {
    window.addEventListener("message", onMessage, false);
}
else if (window.attachEvent) {
    window.attachEvent("onmessage", onMessage, false);
}
function onMessage(event) {
    // Check sender origin to be trusted
    if ( (event.origin !== same_domain_api) && (event.origin !== same_domain)) {
      return;
    }
    var data = event.data;
    if (typeof(window[data.func]) == "function") {
        window[data.func].call(null, data.message);
    }
}
// Function to be called from iframe

var sameNameTemplate = "";
function sameTemplateChoise(message) {
    sameNameTemplate = message;
    samePostAPI(message,"sameTemplateChoise");
}
function sameSaveParentNote(message) {
    sameChangePanelNote();
    sameSaveParentCommon(message);
}
function sameTemplateCloseParent(message) {
    sameFunctionEditClose();
}

function sameTemplateCloseParentGetAgenda(message) {
    sameGetAgenda();
    sameFunctionEditClose();
}
function sameTemplateCloseParentGetParticipantList(message) {
    sameGetParticipantList();
    sameFunctionEditClose();
}
function sameTemplateSaveParent(message) {
    sameSaveParentCommon(message);
}
function sameSaveParentCommon(message) {
    samePostAPI(sameNameTemplate,"sameTemplateSaveParent");
    samePostAPINote();
    sameSetNoteValue( message );
    sameFunctionEditClose();
}

/***** INIZIALIZZA SAME *****/
initSame();
