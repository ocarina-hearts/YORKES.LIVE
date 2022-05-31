<?php
 require"db_connect.php";

 if (mysqli_connect_errno())
 {
 	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	 exit();	
 }

 $ip = $_SERVER['REMOTE_ADDR']; 


 if($connectToServer) {


	$sql = "SELECT coins FROM mainpage WHERE ip = '$ip' LIMIT 1";

	$result = mysqli_query($connectToServer, $sql);
	
	$row = mysqli_fetch_assoc($result);

	echo $row["coins"]; 
	
// 	if (mysqli_num_rows($result) > 0) {
// 		// output data of each row
// 		while($row = mysqli_fetch_assoc($result)) {
// echo  $row["coins"];
// 		}}
	//handles icons
	//$iconsArray = explode(",", $row["icons"]);

	// $sql = "SELECT 1 FROM mainpage WHERE ip = '$ip' LIMIT 1";
	// $result = $connectToServer->query($sql);

	// if ($result->num_rows > 0) {
	// 	// output data of each row
	// 	$row = mysqli_fetch_array($result);
	// 		echo $row['coins'];
	// 		echo "";
		
		
	// } else {
  	// 	echo "0 results";
	// }


} else {
  echo "db_error - getCoins";
}
	
	




?>