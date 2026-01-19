<?php
$filename = 'http://www.cisco.com/c/en/us/td/docs/solutions/Verticals/Financial_Services/md-arch-ext.html';
$ext = pathinfo($filename, PATHINFO_EXTENSION);
echo $ext;