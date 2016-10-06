<?php
  ob_start();
	include("header.php");

  if ($_SESSION[loggued] == "")
    header('Location: ../index.php');
  $stickers_list = scandir("../ressources/stickers");
  ob_flush();
?>
<div class="page-wrap">
  <div class="row">
    <div class="camagru">
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
      <div id="video-container">
        <video id="video"></video>
      </div>
    	<!--<form id="file-form" action="upload.php" method="POST">-->
     <!--   <input type="file" id="file-select" name="photo"/>-->
     <!--   <button type="submit" id="upload-button">Upload</button>-->
     <!-- </form>-->
      <input type="file" onchange="previewFile()"/>
    	<button id="startbutton" class="hover">Prendre une photo</button>
    	<canvas id="canvas"></canvas>
    </div>
    <div id="roulette">
      
    </div>
  </div>
</div>

<script type="text/javascript">
  //--------------------------------------------------------------------Upload
  
  function previewFile() {
    var vidContainer = document.getElementById("video-container");
    video.style.display = "";
    if (upload = document.getElementById("upload"))
      vidContainer.removeChild(upload);    
    var preview = document.createElement('img');
    var file    = document.querySelector('input[type=file]').files[0];
    var reader  = new FileReader();
    
    var ext = file.name.split('.').pop();
    if(ext != "jpeg" && ext != "jpg" && ext != "png")
      return;
    reader.addEventListener("load", function () {
      preview.setAttribute('src', reader.result);
      preview.setAttribute('id', "upload");
      preview.setAttribute('width', "500px");
      video.style.display = "none";
      vidContainer.appendChild(preview);
    }, false);
  
    if (file) {
      reader.readAsDataURL(file);
    }
  }
  //--------------------------------------------------------------------Webcam

  var streaming = false,
      video        = document.querySelector('#video'),
      cover        = document.querySelector('#cover'),
      canvas       = document.querySelector('#canvas'),
      photo        = document.querySelector('#photo'),
      startbutton  = document.querySelector('#startbutton'),
      yo           = document.querySelector('.sticker'),
      roulette     = document.querySelector('#roulette'),
      width = 500,
      height = 0;

  disableStartButton(true);
  
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
    canvas.style.display = "none";
    if (video.style.display == "none") {
      var upload = document.getElementById("upload");
      var img = new Image();
      img.src = upload.getAttribute('src'); 
    } else {
      var data = canvas.toDataURL('image/jpg');
      var img = new Image();
      img.src = data; 
    }
    stickers = document.getElementsByClassName("filter");
    if (stickers.length > 0) {
      xhttp = new XMLHttpRequest(); 
      xhttp.open("POST", "../actions/shot.php", true);
      xhttp.onreadystatechange = function (aEvt) {
        if (xhttp.readyState == 4) {
           if(xhttp.status == 200) {
            newImage = xhttp.responseText;
            displayShot(newImage);
            if (video.style.display == "none") {
              video.style.display = "";
              var upload = document.getElementById("upload");
              var vidContainer = document.getElementById("video-container");
              vidContainer.removeChild(upload);
            }
          }
        }
      };
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      var send = "";
      send += "source=" + img.src +
              "&filter_xpos=" + stickers[0].offsetLeft +
              "&filter_ypos=" + stickers[0].offsetTop +
              "&sticker_src=" + stickers[0].getAttribute("src") +
              "&filter_w=" + stickers[0].width +
              "&filter_h=" + stickers[0].height;
      xhttp.send(send);
    }
  }

  startbutton.addEventListener('click', function(ev){
      takepicture();
    // ev.preventDefault();
  }, false);

  function displayShot(src) {
    img = document.createElement("img");
    img.setAttribute('class', 'photo');
    img.setAttribute('src', src);
    roulette.insertBefore(img, roulette.childNodes[0]);
  }

  function disableStartButton(value) {
    if (value) {
      startbutton.disabled = value;
      startbutton.style.backgroundColor = "#7f8c8d";
      startbutton.style.color = "#bdc3c7";
      startbutton.setAttribute("class", "");
    } else {
      startbutton.disabled = value;
      startbutton.style.backgroundColor = "white";
      startbutton.style.color = "#1BBC9B";
      startbutton.setAttribute("class", "hover");
    }
  }
  //--------------------------------------------------------------------Stickers

  function addSticker(src) {
    if (image = document.getElementById(src)){
      image.parentNode.removeChild(image);
      sticker = document.getElementById("sticker-select");
      for (var i = 0; i < sticker.children.length; i++) {
        if (sticker.children[i].getAttribute("src") == src)
          sticker.children[i].setAttribute("class", "sticker");
      }
      disableStartButton(true);
    } else {
      deleteAllStickers();
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
      image.setAttribute('top', video.height / 2);
      image.setAttribute('left', video.width / 2);
      image.addEventListener("mousedown", initialClick, true);
      vid = document.getElementById("video-container");
      vid.appendChild(image);
      disableStartButton(false);
    }
  }
  
  function deleteAllStickers() {
      vid = document.getElementById("video-container");
      sticker = document.getElementById("sticker-select");
      for (var i = 0; i < sticker.children.length; i++) {
        src = sticker.children[i].getAttribute('src');
        if (image = document.getElementById(src)) {
          vid.removeChild(image);
          sticker.children[i].setAttribute("class", "sticker");
        }
      }
  }

  var moving = false;
  
  function move(e){
    var parent = image.parentElement;
    var newX = e.clientX - parent.offsetLeft - (image.width / 2);
    var newY = e.clientY - parent.offsetTop - (image.height / 2) + window.scrollY;
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
</script>
<?php
	include("footer.php");
?>
</body>
</html>