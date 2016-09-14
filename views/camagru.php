<?php
  ob_start();
	include("header.php");

  $stickers_list = scandir("../ressources/stickers");

    define('UPLOAD_DIR', './');
  if (isset($_POST[source])) {
    $img = $_POST[source];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $name = uniqid();
    $file = UPLOAD_DIR . $name . '.png';
    file_put_contents($file, $data);
    $output = UPLOAD_DIR . uniqid() . "jpg";
    Image::merge($file , $_POST[sticker_src], $output, $_POST[filter_xpos], $_POST[filter_ypos]);
    unlink($file);
    echo $output;
  }
  ob_flush();
?>

<div class="camagru">
  <div id="video-container">
    <video id="video"></video>
  </div>
  <div id="sticker-select">
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
  <img src="<?= $output ?>" id="photo">
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
    stickers = document.getElementsByClassName("filter");
    // for (var i = stickers.length - 1; i >= 0; i--) {
    //   console.log(stickers[i].src);
    // }
    xhttp = new XMLHttpRequest(); 
    xhttp.open("POST", "../actions/shot.php", true);
    xhttp.onreadystatechange = function (aEvt) {
      if (xhttp.readyState == 4) {
         if(xhttp.status == 200)
          // console.log(xhttp.responseText);
          console.log(<?= $_POST[newimage] ?>);
         else
          dump("Erreur pendant le chargement de la page.\n");
      }
    };
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    for (var i = 0; i < stickers.length; i++) {
      xhttp.send("source=" + img.src + "&filter_xpos=" + stickers[i].offsetLeft + "&filter_ypos=" + stickers[i].offsetTop + "&sticker_src=" + stickers[i].getAttribute("src") + "&filter_w=" + stickers[i].width + "&filter_h=" + stickers[i].height);
    }
  }

  startbutton.addEventListener('click', function(ev){
      takepicture();
    ev.preventDefault();
  }, false);

  //--------------------------------------------------------------------Stickers

  var moving = false;

  function addSticker(src) {
    if (image = document.getElementById(src)){
      image.parentNode.removeChild(image);
      sticker = document.getElementById("sticker-select");
      for (var i = 0; i < sticker.children.length; i++) {
        if (sticker.children[i].getAttribute("src") == src)
          sticker.children[i].setAttribute("class", "sticker");
      }

    } else {
      sticker = document.getElementById("sticker-select");
      for (var i = 0; i < sticker.children.length; i++) {
        if (sticker.children[i].getAttribute("src") == src)
          sticker.children[i].setAttribute("class", "sticker selected");
      }
      image = document.createElement("img");
      image.setAttribute('src', src);
      image.setAttribute('id', src);
      image.setAttribute('class', "filter");
      image.setAttribute('width', 80);
      image.setAttribute('height', "auto");
      image.setAttribute('onclick', "init()");
      image.setAttribute('top', video.height / 2);
      image.setAttribute('left', video.width / 2);
      image.addEventListener("mousedown", initialClick, true);
      vid = document.getElementById("video-container");
      vid.appendChild(image);
    }
  }

  function move(e){
    var parent = image.parentElement;
    var newX = e.clientX - parent.offsetLeft - (image.width / 2);
    var newY = e.clientY - parent.offsetTop - (image.height / 2);
    image.style.left = newX + "px";
    image.style.top = newY + "px";
  }

  function initialClick(e) {

    if(moving){
      document.removeEventListener("mousemove", move);
      moving = !moving;
      return;
    }
    
    moving = !moving;
    image = this;

    document.addEventListener("mousemove", move, false);

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