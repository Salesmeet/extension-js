
/****** Screenshots FUNCTION  ************************************************/

function initScreenshotsSameExension() {
  const options = {operation:"sameGetScreenshots", user:sameGetUser(), idmeeting:sameGetIdMeeting() };
  chrome.runtime.sendMessage( same_id_extension , options );
}
