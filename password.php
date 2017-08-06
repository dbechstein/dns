<?php
$salt = substr(str_shuffle("./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz012345??6789"), 0, 10); 
echo $hashed = crypt("DagoberT99", '$6$'.$salt);

?>