<?php
/* vurltool 1.0 */
$vrl = $_SERVER["REQUEST_URI"];
$vrl = preg_replace("/#(.*)$/", "", $vrl);
$vrl = preg_replace("/\?(.*)$/", "", $vrl);
$v = explode("/", $vrl);
unset($v[0]);
$vi = implode("/", $v);
$v = explode("/", $vi);