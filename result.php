<?php 
	include "gd.php"; 
?>
<!DOCTYPE html>
<html>
<title>Done</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<style>
	.button-container > div {
		"display:flex;
		flex-wrap:wrap;
		justify-content:center;
		margin:5px;"
	}
	.button-container {
		display:flex;
		flex-wrap:wrap;
		justify-content:center;
		max-width:600px;
		margin:auto;
	}
</style>
<body>

<div class="w3-container w3-light-grey w3-center">
	<h3>Result</h3>
</div>

<div id="memeImage" class="w3-center w3-section"></div>

<div class="button-container">
	<div class="">
		<a href="index.php" class="w3-btn w3-green">Try another</a>
	</div>
	<div id="memeDownload"></div>
</div>

<script>
	var imageData = <?php echo gdImgToHTML($bgImg, $format); ?>;

	// create image with the data 
	var image = new Image();
	image.src = imageData;
	image.className = 'w3-image';
	var memeImageContainer = document.querySelector('#memeImage');
	memeImageContainer.appendChild(image);

  // create a hidden <a> tag with the image data for downloading the image
	var imageLink = document.createElement("a"); 
	imageLink.href = imageData;
	imageLink.download = "meme_image.png"; // default file name, if supported
	imageLink.innerText = "Download image";
	imageLink.className = 'w3-btn w3-blue';
	var memeDownloadContainer = document.querySelector('#memeDownload');
	memeDownloadContainer.appendChild(imageLink);
</script>

</body>
</html>