<?php

session_start();

//Si hay un usuario logado, se hace logout
if(isset($_SESSION["exitoLogin"])){
	$_SESSION["exitoLogin"] = null;
}

header("Location: index.php");

?>