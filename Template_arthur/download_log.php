<?php
// We'll be outputting a PDF
header('Content-type: application/txt');

// It will be called downloaded.pdf
header('Content-Disposition: attachment; filename="log.txt"');

// The PDF source is in original.pdf
readfile('app_log.log');
?> 