
/****** Screenshots FUNCTION  ************************************************/

function initScreenshotsSameExension() {
  // chrome.runtime.sendMessage( same_id_extension ,"sameGetScreenshots");
  startCapture();
}
async function startCapture() {

  console.log("startCapture");

  html2canvas(document.body).then(function(canvas) {
      document.body.appendChild(canvas);
  });

}
