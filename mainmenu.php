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
include "connectdb.php";
?>

<!--website main title-->
<h1>Western Hospital - Main Menu</h1>
<!-- creating a tagline-->
<em>Where seconds count and treatment is hours away</em>

<!-- dropdown menu of different choices - will redirect to a different php file-->
<h3>What Would You Like to Do: </h3>
<form id="phpForm" method="post">
<select name="page" id="phpDropdown" onchange="navigateToPHP()">
        <option value="0">Select Here</option>
        <option value="getpatient.php">Display Patients</option>
        <option value="addnewpatient.php">Add a New Patient</option>
        <option value="deletepatient.php">Delete a Patient</option>
        <option value="modifypatient.php">Modify a Patient</option>
        <option value="getdoctor.php">Display Doctors</option>
        <option value="getnurse.php">Display Nurses</option>
</select>
<hr>
<input type="submit" value="Select">
</form>
<hr>
<img src="https://i.pinimg.com/1200x/b3/96/63/b3966387b192bb9257cf4565e731c08b.jpg" width="550" height>

<!-- changes php file depending on what user chose-->
<script>
function navigateToPHP() {
    const dropdown = document.getElementById("phpDropdown");
    const form = document.getElementById("phpForm");
    const selectedValue = dropdown.value;
    if (selectedValue !== "0") {
        form.action = selectedValue;
    }
}
</script>
</body>
