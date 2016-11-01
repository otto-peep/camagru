

  var streaming = false,
      video        = document.querySelector('#video'),
      cover        = document.querySelector('#cover'),
      canvas       = document.querySelector('#canvas'),
      photo        = document.querySelector('#photo'),
      capture  = document.querySelector('#capture'),
      upload  = document.querySelector('#Upload'),
      width = 600,
      height = 0;

  capture.disabled=true;
  navigator.getMedia = ( navigator.getUserMedia ||
                         navigator.webkitGetUserMedia || //selon navigateur
                         navigator.mozGetUserMedia ||
                         navigator.msGetUserMedia);

  navigator.getMedia(
    {
      video: true,
      audio: false
    },
    function(stream) { //flux recuperé dans cette fonction
      if (navigator.mozGetUserMedia) {  // pour mozilla
         video.mozSrcObject = stream;
      } else {
        var vendorURL = window.URL || window.webkitURL; //autre navigateurs -> on cree un objet url
        video.src = vendorURL.createObjectURL(stream);
      }
      video.play(); 
    },
    function(err) {
      console.log("An error occured! " + err);
    }
  );

  video.addEventListener('canplay', function(ev){
    if (!streaming) {
      height = video.videoHeight / (video.videoWidth/width);
      video.setAttribute('width', width);
      video.setAttribute('height', height);
      canvas.setAttribute('width', width);
      canvas.setAttribute('height', height);
      streaming = true;
    }
  }, false);

  function takePicture() {
    canvas.width = width;
    canvas.height = height;
    canvas.getContext('2d').drawImage(video, 0, 0, width, height);
    var data = canvas.toDataURL('image/png');
    //console.log(data);
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../php/mergeimg.php", true); //true = asynchrone, synchrone = attend reponse du serveur
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send('fileToUpload=' + data); 
    location.reload();
    console.log('REFRESH');
  }

function disable(){
    document.querySelector('#capture').disabled=false;
    document.getElementById("upload").disabled =null;
    console.log("hello");
  }
