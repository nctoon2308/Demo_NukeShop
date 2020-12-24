<!-- BEGIN: main -->
<!DOCTYPE html>
<html>
<title>W3.CSS</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<body>

<div class="w3-content w3-section" style="max-width:500px">
  <p>The w3-animate-fading class animates an element in and out (takes about 10 seconds).</p>

  <img class="mySlides w3-animate-fading" src="img_rr_01.jpg" style="width:100%">
  <img class="mySlides w3-animate-fading" src="img_rr_02.jpg" style="width:100%">
  <img class="mySlides w3-animate-fading" src="img_rr_03.jpg" style="width:100%">
  <img class="mySlides w3-animate-fading" src="img_rr_04.jpg" style="width:100%">
</div>

<script>
var myIndex = 0;
carousel();

function carousel() {
  var i;
  var x = document.getElementsByClassName("mySlides");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  myIndex++;
  if (myIndex > x.length) {myIndex = 1}    
  x[myIndex-1].style.display = "block";  
  setTimeout(carousel, 9000);    
}
</script>

</body>
</html>
<!-- END: main -->