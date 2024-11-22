<!-- Programmer Name: 71-->
<head>
        <title>Western Hospital</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="hospital.css">
</head>

<body>
<?php
   include 'connectdb.php';
?>

<?php
// function to get imperial height
function metricHeight($feet, $inches) {
   return ($feet * 0.3048) + ($inches * 0.0254);;
}

// function to get imperial weight
function metricWeight($pounds) {
   return $pounds * 0.453592;
}
?>

<?php
// ensure patient was selected
   if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['modifypatient'])) {
       // get the patient's OHIP number
       $ohip = $_POST['modifypatient'];

       // get user input values (height and weight)
       $height = $_POST['height'];
       $height_unit = $_POST['height_unit']; // m or ft
       $weight = $_POST['weight'];
       $weight_unit = $_POST['weight_unit']; // kg or lb

       // if height or weight as imperial, will convert to metric for storage
       if ($height_unit == 'ft') {
           $feet = floor($height); // written as decimals, feet = whole number and inches as decimal 
           $inches = ($height - $feet) * 12;
           $height = metricHeight($feet, $inches);
       }
       if ($weight_unit == 'lb') {
           $weight = metricWeight($weight);
       }

       // update selected patient data
       $query = "UPDATE patient
                 SET height = $height, weight = $weight
                 WHERE ohip = '$ohip'";

       // tell user is query was successful
       if (!mysqli_query($connection, $query)) {
           die("Error: " . mysqli_error($connection));
       } else {
           echo "Modification Successful!";
       }
   }
?>

<!-- displaying patients-->
<h1>Modify Patient:</h1>
<form method="post" action="">
   <h3>Select Patient:</h3>
   <?php
   // list all patients
   $query = "SELECT ohip, firstname, lastname FROM patient";
   $result = mysqli_query($connection, $query);
   // creating radio buttons for each patient
   echo "<form action='' method='post'>";
   while ($row = mysqli_fetch_assoc($result)) {
      $ohip = $row['ohip'];  // selecting patients ohip
      $fullName = $row['firstname'] . ' ' . $row['lastname'];  // accessing patients name

      // generate a radio button for each patient
      echo "<input type='radio' name='deletepatient' value='$ohip'> $fullName <br>";
   }
   ?>

   <!-- text box for user to give height -->
   <label for="height">Height:</label>
   <input type="text" name="height" required>
   <select name="height_unit"> // creating dropdown option to indicate if m or ft
       <option value="m">m</option>
       <option value="ft">ft</option>
   </select><br>
   
   <!-- text box for user to give weight-->
   <label for="weight">Weight:</label>
   <input type="text" name="weight" required>
   <select name="weight_unit"> // creating dropdown option to indicate if kg or lb
       <option value="kg">kg</option>
       <option value="lb">lb</option>
   </select><br>

   <input type="submit" value="Modify Patient">
</form>

<!-- hyperlink to main menu -->
<p>
<a href="mainmenu.php">Back to Main Menu</a>
</p>

</body>
</html>
