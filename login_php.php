<?php

   $host="localhost";
   $user="root";
   $pass="";
   $db_name="chat";

   $conn=mysqli_connect($host,$user,$pass,$db_name);
   if($conn)
   {
     if(isset($_POST['register']))
     {
      $name=filter_input(INPUT_POST,'name');
      $username=filter_input(INPUT_POST,'username');
      $email=filter_input(INPUT_POST,'emailid');
      $pass=filter_input(INPUT_POST,'pass');
//$dp_name=filter_input(INPUT_POST,'dp');
      $image_name=$_FILES['dp']['name'];
      $image_tmploc=$_FILES['dp']['tmp_name'];
      move_uploaded_file($image_tmploc, 'uploadimage/'.$image_name);
      $sql="INSERT INTO users values('$name','$username','$email','$pass','$image_name')";
      $run=mysqli_query($conn,$sql);
      if($run)
      {
          echo "<script type='text/javascript'> alert('Thank you for Registering for us! Please login!');</script>";
      }
      else
      {
          echo "<script type='text/javascript'> alert('Sorry!');</script>";
          die(mysqli_error($conn));
      }

     }
     if(isset($_POST['login']))
     {
         session_start();
         $username=filter_input(INPUT_POST,'username');
         $pass=filter_input(INPUT_POST,'pass');
          $sql="SELECT * FROM users where username = '$username' AND pass='$pass' ";
          $qresult= $conn -> query($sql);
         if(!$row = $qresult -> fetch_assoc())
         {
            //header("Location:error.php");
             echo " <script type='text/javascript'> alert('Sorry! Wrong Username or Password!');</script> ";
         }
         else
         {
             $sql1="Select name FROM users where username='$username'"; 
             $qresult1= $conn -> query($sql1);
        
         if($qresult1)
         {
         
            while($rows=mysqli_fetch_array($qresult1))
            {
              $name=$rows['name'];
            }
          }
           // $_SESSION['s_realname']=$_POST[$name];
            $_SESSION['s_name']=$_POST['username'];
            
            //echo $_SESSION['s_realname'];
            header("Location:home.php");
         }


     }
   }
   else
   {
    die("connection not established :". mysqli_connect_error($conn));
   }

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style type="text/css">
		#logindiv_id
		{
			display: block;
		}
		#signupdiv_id
		{
			display: none;
		}
	</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" ></script>
<!-- <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script> -->
<!-- <script type="text/javascript" src="jqfile.js"></script> -->
<script >
	function signup_visible()
	{
          signup_div=document.getElementById("signupdiv_id")
          login_div=document.getElementById("logindiv_id")
          if(signup_div.style.display=="none")
          {
          	signup_div.style.display="block";
            login_div.style.display="none";

          }
          else
          	{
              signup_div.style.display="none";
              login_div.style.display="block";

            }
	}

  function login_visible()
  {
          login_div=document.getElementById("logindiv_id");
          signup_div=document.getElementById("signupdiv_id")

          if(login_div.style.display=="none")
          {
            login_div.style.display="block";
            signup_div.style.display="none";
          }
          else
           {
               signup_div.style.display="block";
              login_div.style.display="none"; 
           }
  }
// $(document).ready(function(){
//      //document.write("coming2");
//       $("#logindiv_id").fadeIn();
//      // $("#login_a_id").click(function(){ 
//      //  // document.write("coming2");
//      //  $("#logindiv_id").fadeIn();
//      //  $("signupdiv_id").hide();
//       // $("#div2").fadeIn("slow");
//       // $("#div3").fadeIn(3000);
//     })

//     $("#signup_a_id").click(function(){ 
//         //document.write("coming1");
//       $("#signupdiv_id").fadeIn();
//       $("logindiv_id").hide();
//       // $("#div2").fadeIn("slow");
//       // $("#div3").fadeIn(3000);
//     })
  
  
//    })

// $(document).ready(function(){
//    $("#btn_login_id").click(function()
//    {
//     $("#signupdiv_id").fadeIn();
//     $("#logindiv_id").hide();
//    });
//  });

// $(document).ready(function(){
//   $(#signupdiv_id).hide();
//   $(#signup_a_id).click(function(){
//     $(#logindiv_id).fadeOut("slow",function(){
//       $(#signupdiv_id).fadeIn();
//     })
//   })

//   $(#login_a_id).click(function(){
//     $(#signupdiv_id).fadeOut("slow",function(){
//       $(#logindiv_id).fadeIn();
//     })
//   })
// })


function validate()
{
    if(signup_form.name.value=="")
    {
      alert("Please enter the Name");
      return false;
    }
    else if(signup_form.username.value=="")
    {
      alert("Please enter the Username");return false;
    }
     else if(signup_form.emailid.value=="")
    {
      alert("Please enter the Email ID");return false;
    }
     else if(signup_form.pass.value=="")
    {
      alert("Please enter the Password");return false;
    }
     else if(signup_form.confirm_password.value=="")
    {
      alert("Please Re-Enter the Password");return false;
    }
     else if(signup_form.confirm_password.value!=signup_form.pass.value)
    {
      alert("Passwrds do not match!!");
      signup_form.pass.value="";
      signup_form.confirm_password.value="";return false;

    }
     else if(signup_form.image.value=="")
    {
      alert("Please upload an image!");return false;
    }
    else
    {
      return true;
    }

}


</script>

	<link rel="stylesheet" type="text/css" href="login_css.css">

</head>
<body>
      <div id="logindiv_id">
      	<form name="login_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      		<h3 id="loginheading_div">LOGIN</h3>
      		<div id="login_username_div_id">
      			<input class="login_input" type="text" name="username" placeholder="Username">
      		<i class="fa fa-user fa-lg fa-fw" aria-hidden="true"></i><br>
      		</div>
      		<div id="login_pass_div_id">
      			<input class="login_input" type="password" name="pass" placeholder="Password">
      		<i class="fa fa-user-secret fa-lg fa-fw" aria-hidden="true"></i><br>
      		</div>
      		<p>Not a member yet ? Please <a id="signup_a_id" onclick="signup_visible()">Sign Up</a> </p>
      		<input id="btn_login_id"  class="login_input" type="submit" name="login" value="Login"><br>
      	</form>
      </div>

      <div id="signupdiv_id">
      	<form name="signup_form" method="POST" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      		<h3 id="signupheading_div">SIGNUP</h3>
      		<input class="signup_input" type="text" name="name" placeholder="Full Name"><br>
      		<input class="signup_input" type="text" name="username" placeholder="Username"><br>
      		<input class="signup_input" type="text" name="emailid" placeholder="Email ID"><br>
      		<input class="signup_input" type="password" name="pass"  placeholder="Password"><br>
      		<input class="signup_input" type="password" name="confirm_password" placeholder="Confirm Password"><br>
          Select a Profile Picture : <br>
          <input class="signup_input" type="file" name="dp" >
      		<p>Already a member ? Please <a id="login_a_id" onclick="login_visible()">Login</a> </p>
      		<input id="btn_signup_id" class="signup_input" type="submit" name="register" value="Register" onclick="return validate();"><br>
          <input type="reset" name="reset"><br>
      	</form>
      </div>
</body>
</html>