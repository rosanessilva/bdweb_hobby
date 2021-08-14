<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>


<link rel="stylesheet" href="style.css">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=3">
<head>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<script>

		$(document).ready(function () {
			$("#logo").click(function () {
				$(".profile").toggle("fast");
			});
			$("#profilebox").mouseleave(function () {
				$(".profile").hide();
			});
		});
	</script>

</head>
<body>

	<h2>
		<div id="MenuList">
			<ul id="menu">
				<a href="">
				<li class="seletor">Home</li></a>
				<a href="">
				<li class="seletor">Agenda</li></a>
				<a href="">
				<li class="seletor">Pendências</li></a>
				<a href="">
				<li class="seletor">Tarefas</li></a>
				<a href="">
				<li class="seletor">Lembretes</li></a>
				<a href="">
				<li class="seletor"> TESTANDO </li></a>
			</ul>

		</div>
		<div id=logo>
			<div id="profilebox" class="profile">
				<ul id="options">
					<a href="">
					<li class="optmenu">Home</li></a>
					<a href="">
					<li class="optmenu">Agenda</li></a>
					<a href="">
					<li class="optmenu">Pendências</li></a>
					<a href="">
					<li class="optmenu">Tarefas</li></a>
					<a href="">
					<li class="optmenu">Lembretes</li></a>
					<a href="">
					<li class="optmenu">Aniversariantes</li></a>
				</ul>
			</div>
		</div>
	</h2>


	<p>Welcome to index test.</p>

	<footer>

		<a href="logout.php" class="btn btn-warning">Sair</a>


	</footer>

</body>
</html>
