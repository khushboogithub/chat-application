<?php

session_start();
if(isset($_SESSION['s_name']))
{
	  $_SESSION['s_name'];
	 //echo $_SESSION['s_realname'];
}



if(isset($_POST['send']))
{
	$host="localhost";
   $user="root";
   $pass="";
   $db_name="chat";

   $conn=mysqli_connect($host,$user,$pass,$db_name);
   if($conn)
    { 
   	   $msg=filter_input(INPUT_POST,'msg');
       $username=$_SESSION['s_name'];
       $sql1="Select name FROM users where username='$username'"; 
			   $qresult1= $conn -> query($sql1);
			  
			   if($qresult1)
			   {
					  while($rows=mysqli_fetch_array($qresult1))
					  {
						  $name=$rows['name'];
						   $sql2="INSERT INTO chats(username,name,msg) values ('$username','$name','$msg')";
    	  		              $qresult2 = $conn-> query($sql2);
						  
					  }
			   }
			 	else
			 	  {
			 	  	echo "something went wrong";
			 	  }

          //        $sql2="INSERT INTO chats(username,name,msg) values ('$username','$name','$msg')";
    	  		 // $qresult2 = $conn-> query($sql2);
    	  		 // if($qresult2)
    	  		 // {
    	  		 // 	echo "done";
    	  		 // }
    	  		 // else
    	  		 // {
    	  		 // 	echo "not done";
    	  		 // 	echo (mysqli_connect_error($conn));
    	  		 // }
				

   }
   else
   {
    die("connection not established :". mysqli_connect_error($conn));
   }
}

if(isset($_POST['logout']))
{
	session_destroy();
	header("Location:login_php.php");
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
</head>
<body>
	<div id="main">
		<h1 style="color: red"> <?php echo $_SESSION['s_name']?> Online </h1>
	</div>
	<div id="output_div">
		<?php
          $host="localhost";
   $user="root";
   $pass="";
   $db_name="chat";

   $conn=mysqli_connect($host,$user,$pass,$db_name);
   if($conn)
    { 
			$sql3="SELECT * FROM chats ";
			$qresult3= $conn-> query($sql3);
			if($qresult3->num_rows > 0)
			{
				while($row = $qresult3->fetch_assoc())
				{
					 echo  " ". $row['name']. "<i> says </i> " . $row['msg'] . "<br>---" . $row['datetime'] . '<br>';
					
					echo '<br>';
				}
			}
			else
			{
				echo "Start your chat now !!";
			}
           $conn -> close();
      }
      else
      {
      	die("connection not established :". mysqli_connect_error($conn));
      }
		?>
	</div>

	<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<textarea name="msg" placeholder="Type your message here!... "></textarea><br>
		<input type="submit" name="send" value="Send">
	</form>
	<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<input type="submit" name="logout" value="Logout">
	</form>

</body>
</html>