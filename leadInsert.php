
<?php
$mysqli = new mysqli("localhost","root","","conductlogicdb");
$lastModifiedAgentId = 0;



function getLastEmailedAgentId(){
$sql = "Select agent_id from leads order by modified desc limit 1";
global $mysqli;
$result = $mysqli->query($sql);
$lastModifiedAgentId = $result->fetch_row();
$result->close();
return $lastModifiedAgentId[0];
}


function getMinLeadAgentId(){

global $mysqli;
$sqlAgent = "SELECT id from agents where active = '0' AND id not in (SELECT agent_id from leads)";

$resultAgent = $mysqli->query($sqlAgent);
$count = $resultAgent->num_rows;
//echo "new agent";
//echo $count."<br>";
if($count != 0){
	while($availableAgentId = $resultAgent->fetch_row()){
			return $availableAgentId[0];
		//	echo "this is new agent";
		//	printf ("%s \n", $availableAgentId[0]);
	}

}
else{
//	echo "last mailed agent:";
	
	$temp = getLastEmailedAgentId();
//	echo "temp".$temp."<br>";
	$resultCheck = $mysqli->query("Select * from agents where active = '0'");
	$count = $resultCheck->num_rows;
//	echo "count". $count;
	if($count == 1){
		
		$sql = "SELECT agent_id,MIN( lead ) AS 'lead'
FROM 
    (
    SELECT agent_id, COUNT( * ) AS  'lead'
    FROM leads where agent_id in (select id from agents where active = '0')
    GROUP BY agent_id order by lead asc, modified asc
    )AS temp2";

	}
	elseif($count == 0){

		return false;
	}
	else{
$sql = "SELECT agent_id,MIN( lead ) AS 'lead'
FROM 
    (
    SELECT agent_id, COUNT( * ) AS  'lead'
    FROM leads where agent_id in (select id from agents where active = '0' and id <> $temp)
    GROUP BY agent_id order by lead asc, modified asc
    )AS temp2";}
$result = $mysqli->query($sql);
	
		while($availableAgentId = $result->fetch_row()){
			return $availableAgentId[0];
		//	echo "new lead";
		//	printf ("%s \n", $availableAgentId[0])."<br>";
	}
}
	
$result->close();
}
if (isset($_POST['save'])){

	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$message = $_POST['message'];
	//echo getLastEmailedAgentId();
	
	$AgentId = getMinLeadAgentId();
	//echo $AgentId."<br>";
	$insert = $mysqli->query("INSERT INTO `leads`( `agent_id`, `first_name`, `last_name`, `email`, `mobile`, `message`)
	                          VALUES ('$AgentId','$fname','$lname','$email','$phone','$message')");

	$sql = "select * from agents where id = '$AgentId'";
	$result =$mysqli->query($sql);
	while($row = $result->fetch_assoc()){

		$agent_fname = $row['first_name'];
		$agent_lname = $row['last_name'];
		$agent_email = $row['email'];
		$mobile = $row['mobile'];
	}
	if($insert)
		{

			print("Success");


	$messageLead = "Thanks for the Registration\r\nYour agen name is:". $agent_fname . $agent_lname."\r\n".$email."\r\n".$mobile;
	$messageAgent = "New Lead\r\n name is:". $fname . $lname."\r\n". $email."\r\n". $mobile;

	// Send
	mail('$email', 'ConductHQ Registration', $messageLead);
	mail('$agent_email', 'New Lead', $messageAgent);



}
	else{print($mysqli->error);}



	
}
else
{
//	echo "Not Posted";
}




?>