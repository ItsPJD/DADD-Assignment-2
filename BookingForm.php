<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
$adultsNumErr = $childNumErr = $cotErr = $hChairErr = $arrivalErr = $deptErr = $propertyErr = "";
$adultsNum = $childNum = $cot = $hChair = $arrival = $dept = $property = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["property"])) {
    $propertyErr = "This field is required";
  } else {
    $property = booking_input($_POST["property"]);
  }

  if (empty($_POST["num_adults"])) {
    $adultsNumErr = "A number of adults is required";
  } else {
    $adultsNum = booking_input($_POST["num_adults"]);
    if (!preg_match("/^[0-9]*$/",$adultsNum)) {
      $adultsNumErr = "Invalid input - please enter correct amount of adults for the holiday as a number (0-9)";
    }
  }

  if (empty($_POST["num_child"])) {
    $childNum = "";
  } else {
    $childNum = booking_input($_POST["num_child"]);
    if (!preg_match("/^[0-9]*$/",$childNum)) {
      $childNumErr = "Invalid input - please enter correct amount of children for the holiday as a number (0-9)";
    }
  }

  if (empty($_POST["Need_Cot"])) {
    $cotErr = "This field is required";
  } else {
    $cot = booking_input($_POST["Need_Cot"]);
  }

  if (empty($_POST["Need_High_Chair"])) {
    $hChairErr = "This field is required";
  } else {
    $hChair = booking_input($_POST["Need_High_Chair"]);
  }

  if (empty($_POST["arrival_Date"])) {
    $arrivalErr = "This field is required";
  } else {
    $arrival = booking_input($_POST["arrival_Date"]);
  }

  if (empty($_POST["dept_Date"])) {
    $deptErr = "This field is required";
  } else {
    $dept = booking_input($_POST["dept_Date"]);
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
  if($adultsNumErr == "" && $childNumErr == "" && $cotErr == "" && $hChairErr == "" && $arrivalErr == "" && $deptErr == "" && $propertyErr == "")
  {
    $sql = "INSERT INTO booking (property_Id, num_adults, num_children, needs_cot, needs_hchair, arrival_date, dept_date)
    VALUES ( '$property', '$adultsNum', '$childNum', '$cot', '$hChair', '$arrival', '$dept')";

    if ($conn->query($sql) === TRUE) {
      echo " New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    
    }

    $conn->close();
  }
}

?>



<div id="booking">
<hr>
<br>
<h1> Booking form </h1>
<br>
<hr>
<h2>Booking Form: </h2>

<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Property Location:
  <input type="radio" name="property" <?php if (isset($property) && $property=="1") echo "checked";?> value="1">Madrid
  <input type="radio" name="property" <?php if (isset($property) && $property=="2") echo "checked";?> value="2">Berlin
  <input type="radio" name="property" <?php if (isset($property) && $property=="3") echo "checked";?> value="3">Rome
  <input type="radio" name="property" <?php if (isset($property) && $property=="4") echo "checked";?> value="4">Athens
  <input type="radio" name="property" <?php if (isset($property) && $property=="5") echo "checked";?> value="5">Paris
  <input type="radio" name="property" <?php if (isset($property) && $property=="6") echo "checked";?> value="6">London
  <span class="error">* <?php echo $propertyErr;?></span>
  <br><br>

  Number of Adults: <input type="text" name="num_adults" value="<?php echo $adultsNum;?>"> 
  <span class="error">* <?php echo $adultsNumErr;?></span>
  <br><br>

  Number of Children: <input type="text" name="num_child" value="<?php echo $childNum;?>"> 
  <span class="error">* <?php echo $childNumErr;?></span>
  <br><br>

  Need Cot:
  <br>
  <input type="radio" name="Need_Cot" <?php if (isset($cot) && $cot=="Yes") echo "checked";?> value="Yes">Yes
  <input type="radio" name="Need_Cot" <?php if (isset($cot) && $cot=="No") echo "checked";?> value="No">No
  <span class="error">* <?php echo $cotErr;?></span>
  <br><br>

  Need High Chair:
  <br>
  <input type="radio" name="Need_High_Chair" <?php if (isset($hChair) && $hChair=="Yes") echo "checked";?> value="Yes">Yes
  <input type="radio" name="Need_High_Chair" <?php if (isset($hChair) && $hChair=="No") echo "checked";?> value="No">No
  <span class="error">* <?php echo $hChairErr;?></span>
  <br><br>

  Arrival Date:
  <input type="date" name="arrival_Date" value="<?php echo $arrival;?>"> 
  <span class="error">* <?php echo $arrivalErr;?></span>
  <br><br>

  Departure Date:
  <input type="date" name="dept_Date" value="<?php echo $dept;?>"> 
  <span class="error">* <?php echo $deptErr;?></span>
  <br><br>
  
  <input type="submit" name="submit" value="Submit">  
</form>
</div>

</body>
</html>