<?php	

$file = "/UploadedImages/WebTWAINImage.jpg";

header('Content-type: image/jpg');

// It will be called downloaded.pdf
header('Content-Disposition: appendedheader; filename="WebTWAINImage.jpg"');

// The PDF source is in original.pdf
readfile('WebTWAINImage.jpg');

?>