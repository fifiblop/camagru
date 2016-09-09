<?php
  ob_start();
	include("header.php");

  $stickers_list = scandir("../ressources/stickers");
  ob_flush();
?>

<div class="camagru">
  <div id="video-container">
    <video id="video"></video>
  </div>
  <div class="sticker-select">
  <?php 
    $path = "../ressources/stickers/";
    foreach ($stickers_list as $stick) {
      if ($stick[0] != '.') {
        $stick = $path . $stick;
        echo "<img class='sticker' onclick='addSticker(\"" . $stick . "\")' src='" . $stick . "'>";
      }
    }
  ?>
 </div>
	<button id="startbutton">Prendre une photo</button>
	<canvas id="canvas"></canvas>
  <img src="" id="photo">
</div>

<script type="text/javascript">

  //--------------------------------------------------------------------Webcam

  var streaming = false,
      video        = document.querySelector('#video'),
      cover        = document.querySelector('#cover'),
      canvas       = document.querySelector('#canvas'),
      photo        = document.querySelector('#photo'),
      startbutton  = document.querySelector('#startbutton'),
      yo           = document.querySelector('.sticker'),
      width = 500,
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


  function takepicture() {
    canvas.width = width;
    canvas.height = height;
    canvas.getContext('2d').drawImage(video, 0, 0, width, height);
    var data = canvas.toDataURL('image/jpg');
    var img = new Image();
    img.src = data; 
    sticker = document.getElementById("filter");
    xhttp = new XMLHttpRequest(); 
    xhttp.open("POST", "../actions/shot.php", true);
    xhttp.onreadystatechange = function (aEvt) {
      if (xhttp.readyState == 4) {
         if(xhttp.status == 200)
          console.log(xhttp.responseText);
         else
          dump("Erreur pendant le chargement de la page.\n");
      }
    };
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("source=" + img.src + "&filter_xpos=" + sticker.offsetLeft + "&filter_ypos=" + sticker.offsetTop + "&sticker_src=" + sticker.getAttribute("src"));
  }

  startbutton.addEventListener('click', function(ev){
      takepicture();
    ev.preventDefault();
  }, false);

  //--------------------------------------------------------------------Stickers

  function addSticker(src) {
    console.log(src);
    image = document.createElement("img");
    image.setAttribute('src', src);
    image.setAttribute('id', "filter");
    image.setAttribute('width', 160);
    image.setAttribute('height', "auto");
    image.setAttribute('onclick', "init()");
    vid = document.getElementById("video-container");
    vid.appendChild(image);
  }

  //-----------------------------------------------------------redimensionnement 


  // var p = document.querySelector("#filter");

  // p.addEventListener('click', function init() {
  //     p.removeEventListener('click', init, false);
  //     p.className = p.className + 'resizable';
  //     var resizer = document.createElement('div');
  //     resizer.className = 'resizer';
  //     p.appendChild(resizer);
  //     resizer.addEventListener('mousedown', initDrag, false);
  //     console.log('init');
  // }, false);


  // var startX, startY, startWidth, startHeight;

  // function initDrag(e) {
  //     console.log('initDrag');
  //    startX = e.clientX;
  //    startY = e.clientY;
  //    startWidth = parseInt(document.defaultView.getComputedStyle(p).width, 10);
  //    startHeight = parseInt(document.defaultView.getComputedStyle(p).height, 10);
  //    document.documentElement.addEventListener('mousemove', doDrag, false);
  //    document.documentElement.addEventListener('mouseup', stopDrag, false);
  // }

  // function doDrag(e) {
  //    p.style.width = (startWidth + e.clientX - startX) + 'px';
  //    p.style.height = (startHeight + e.clientY - startY) + 'px';
  //     console.log('doDrag');
  // }

  // function stopDrag(e) {
  //     document.documentElement.removeEventListener('mousemove', doDrag, false);
  //     document.documentElement.removeEventListener('mouseup', stopDrag, false);
  //     console.log('stopDrag');
  // }


</script>
<?php
	include("footer.php");
?>
</body>
</html>