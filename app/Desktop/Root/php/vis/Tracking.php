<?php
	include ($_SERVER['DOCUMENT_ROOT']."/".explode("/", $_SERVER['REQUEST_URI'])[1]."/app/core/ic.const.php");

	@session_start();
	@$_SESSION['call'] = "On";

	include (PF_CONNECT_SERVER);
	include (PD_DESKTOP_ROOT_PHP."/gn.ssh.class.php");

	$CN = new ConnectSSH();
	$CN->ConnectDB($H, $U, $P, $D, $X);

	$time_start = microtime(true);

	$CN->SpaceTest();

	include (PD_DESKTOP_ROOT_PHP."/vis/images.php");

	$time_end = microtime(true);
	$time = $time_end - $time_start;

?>

<input type="hidden" id="input_retardo" value="Retardo de tiempo: <?php echo number_format($time, 2, '.', ''); ?> seg." />

<style>
	.show_elements {
	  padding: 10px; background-color: rgba(0,0,0,.1);
	}
	.show_elements:hover {
	  cursor: pointer;
	  background-color: rgba(0,0,0,.2);
	}
</style>