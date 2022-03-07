
/****** RECORD FUNCTION  ************************************************/

/* salva i dati per il record della registrazione audio  */
function samePostAPIRecord( url ) {
      var data = new FormData();
      data.append('file', url );
      samePostAPICommon(same_domain_api + '/api/v1/postrecord.php',data);
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

        // alert("same_stop_button onclick");

        const options = {operation:"stopSame", user:sameGetUser(), idmeeting:sameGetIdMeeting(), type:"back"};
        chrome.runtime.sendMessage( same_id_extension , options);

        // alert("same_stop_button after same_id_extension");

        mediaRecorder.stop();
        console.log(mediaRecorder.state);
        console.log("recorder stopped");
        same_record_button.style.background = "";
        same_record_button.style.color = "";
        // mediaRecorder.requestData();

        same_stop_button.disabled = true;
        same_cancel_button.disabled = true;
        same_record_button.disabled = false;


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

        const options = {operation:"cancelSame", user:sameGetUser(), idmeeting:sameGetIdMeeting(), type:""};
        chrome.runtime.sendMessage( same_id_extension ,options);

      }

      mediaRecorder.onstop = function(e) {

        console.log("data available after MediaRecorder.stop() called.");

        /*
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
        */

        const blob = new Blob(chunks, { 'type' : 'audio/ogg; codecs=opus' });

        /*
        chunks = [];

        const audioURL = window.URL.createObjectURL(blob);

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
        */


        //the form data that will hold the Blob to upload
        const formData = new FormData();
        //add the Blob to formData
        formData.append('fileToUpload', blob, 'recording.mp3');
        formData.append('idmeeting', sameGetIdMeeting() );
        formData.append('type', "microphone" );
        formData.append('user', sameGetUser());
        formData.append('extension', "ogg");

        //send the request to the endpoint
        var xhr = new XMLHttpRequest();
        xhr.open('POST', "https://api.sameapp.net/public/v1/record/save", true);
        xhr.onload = function () {
            // alert("onload________" + this.status);
        };
        xhr.onreadystatechange = function() {
            // alert("onreadystatechange________" + this.status);
        };
        try {
          xhr.send(formData);
        } catch (error) {
          // alert("error________" + error);
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
    const options = {operation:"startSame", user:sameGetUser(), idmeeting:sameGetIdMeeting(), type:""};
    chrome.runtime.sendMessage( same_id_extension ,options);
}

window.onload = function() {
  sameInitRecord();
};
