console.log('js');

function uploadPhoto(){
    var filters = document.getElementsByName('filter');
    for (var i = 0, length = filters.length; i < length; i++){
      if (filters[i].checked){
        console.log(filters[i].value);
        document.getElementById('formUpload').submit();
        return ;
      }
      else if (i == length - 1){
        alert ('Vous devez selectionner un filtre!');
        }
    }
};

	(function() {

  var streaming = false,
      video        = document.querySelector('#video'),
      cover        = document.querySelector('#cover'),
      canvas       = document.querySelector('#canvas'),
      photo        = document.querySelector('#photo'),
      startbutton  = document.querySelector('#capture'),
      width = 320,
      height = 0;

  navigator.getMedia = ( navigator.getUserMedia ||
                         navigator.webkitGetUserMedia ||
                         navigator.mozGetUserMedia ||
                         navigator.msGetUserMedia);

  navigator.getMedia(
    {
      video: true,
      audio: false
    },
    function(stream) {
      if (navigator.mozGetUserMedia) {
        video.mozSrcObject = stream;
      } else {
        var vendorURL = window.URL || window.webkitURL;
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
    var filters = document.getElementsByName('filter');
    for (var i = 0, length = filters.length; i < length; i++){
      if (filters[i].checked){
        console.log(filters[i].value);
        var filter = filters[i].value;
      }
    }
    if (!filter){
        return alert ('Vous devez selectionner un filtre!');
    }
    var desc = document.getElementById('desc').value;
    canvas.width = width;
    canvas.height = height;
    canvas.getContext('2d').drawImage(video, 0, 0, width, height);
    var data = canvas.toDataURL('image/png');
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../php/mergeimg.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=UTF-8");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.response);
            console.log(response);
            if (response !== "ok") {
                alert(response);
            }
            else{
              location.reload();
            }
        }
    };
    xhr.send("description="+desc+"&filter="+ filter + "&image64=" + encodeURIComponent(data.replace("data:image/png;base64,", "")));
  }

  startbutton.addEventListener('click', function(ev){
      takePicture();
    ev.preventDefault();
  }, false);

  
})();