
/****** RECORD FUNCTION  ************************************************/

/* salva i dati per il record della registrazione audio  */
function samePostAPIRecord( url ) {
      var data = new FormData();
      data.append('file', url );
      samePostAPICommon(same_domain_api + '/api/v1/postrecord.php',data);
}
function sameCreateFile( url ) {
    var temp = '<form method="POST" enctype="multipart/form-data" action="' + same_domain_api + '/api/v1/postrecord.php">\
    <input type="file" name="file">\
    <button type="submit" role="button">Upload File</button>\
    </form>';
    document.getElementById("same_common").innerHTML = escapeHTMLPolicy.createHTML(temp);
    sameChangePanelCommon();
}

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

        initVideoSameExension();

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

        chrome.runtime.sendMessage( same_id_extension ,"stopSame");

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

        chrome.runtime.sendMessage( same_id_extension ,"cancelSame");

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

function initVideoSameExension() {
    chrome.runtime.sendMessage( same_id_extension ,"startSame");
}

// sameInitRecord();
