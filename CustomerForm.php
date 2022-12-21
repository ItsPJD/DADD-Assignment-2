<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
$fnameErr = $lnameErr = $emailErr = $phoneErr =  "";
$fname = $lname = $email = $phone =  "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["fname"])) {
    $fnameErr = "First name is required";
  } else {
    $fname = booking_input($_POST["fname"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$fname)) {
      $fnameErr = "Only letters and white space allowed";
    }
  }
  
  if (empty($_POST["lname"])) {
    $lnameErr = "Last name is required";
  } else {
    $lname = booking_input($_POST["lname"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$lname)) {
      $lnameErr = "Only letters and white space allowed";
    }
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = booking_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }
    
  if (empty($_POST["phone"])) {
    $phoneErr = "A phone number is required";
  } else {
    $phone = booking_input($_POST["phone"]);
    if (!preg_match("/^[0-9]*$/",$phone)) {
      $phoneErr = "Invalid phone number";
    }
  }
}

function booking_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<?php
$servername = "localhost"; 
$username = "root";	
$password = ""; 
$database ="holidayrentals"; 

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
if (isset($_POST['submit'])){
  if($fnameErr == "" && $lnameErr == "" && $emailErr == "" && $phoneErr == "")
  {
    $sql = "INSERT INTO customers (f_name, l_name, email_address, phone_number)
    VALUES ( '$fname', '$lname', '$email', '$phone')"; 

    if ($conn->query($sql) === TRUE) {
      echo " New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    
    }

    $conn->close();
  }
}

?>



<div id="customer">
<hr>
<br>
<h1> Customer Registration form </h1>
<br>
<hr>
<h2>Customer Registration Form: </h2>

<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  First Name: <input type="text" name="fname" value="<?php echo $fname;?>">
  <span class="error">* <?php echo $fnameErr;?></span>
  <br><br>
  
   Last Name: <input type="text" name="lname" value="<?php echo $lname;?>">
  <span class="error">* <?php echo $lnameErr;?></span>
  <br><br>
  
  E-mail: <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error">* <?php echo $emailErr;?></span>
  <br><br>
   
  Phone Number: <input type="text" name="phone" value="<?php echo $phone;?>"> 
  <span class="error">* <?php echo $phoneErr;?></span>
  <br><br>
   
  <input type="submit" name="submit" value="Submit">  
</form>
</div>

</body>
</html>