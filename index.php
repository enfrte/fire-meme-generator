<!DOCTYPE html>
<html>
<title>It's on fire, yo</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<body>

<div class="w3-container w3-light-grey w3-center">
	<h3>Enter a PNG or JPEG URL or file of something on fire</h3>
</div>

<div class="w3-section" style="max-width:767px;margin: 0 auto">
	
	<form class="" action="result.php" method="post" enctype="multipart/form-data">
		<div class="w3-container" style="margin-bottom:-16px;">
			<p><label>URL: </label><input class="w3-input w3-border" type="text" id="urlinput" name="url" /></p>
			<p><label>File: </label><input class="w3-input w3-border-0" type="file" id="fileinput" name="file" accept="image/*" /></p>
		</div>
		
		<div class="w3-row-padding">
			<div class="w3-half">
				<button class="w3-btn w3-block w3-green w3-margin-top" type="submit">Submit</button> 
			</div>
			<div class="w3-half">
				<input class="w3-block w3-btn w3-red w3-margin-top" type="reset" value="Reset" />
			</div>
		</div>
	
	</form>
	
	<p class="w3-center">Hosting provided by <a href="http://vlexofree.com/">VlexoFree Hosting</a></p>

</div>

<script src="gd.js"></script>
</body>
</html>