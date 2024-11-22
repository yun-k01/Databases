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
// ensure data is submitted before being processed
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deletepatient'])) {
   // radio button selects patient to be deleted
   $ohip = $_POST['deletepatient'];
}
?>

<h1>Delete Patient:</h1>
<?php
// list all patients
$query = "SELECT ohip, firstname, lastname FROM patient";
$result = mysqli_query($connection, $query);

// check if query was successful
if (!$result) {
    die("Error: " . mysqli_error($connection));
}

// creating radio buttons for each patient
echo "<form action='' method='post'>";
while ($row = mysqli_fetch_assoc($result)) {
    $ohip = $row['ohip'];  // accessing the ohip number
    $fullName = $row['firstname'] . ' ' . $row['lastname'];  // accessing patient name

    // generate a radio button for a patient
    echo "<input type='radio' name='deletepatient' value='$ohip'> $fullName <br>";
}

// confirmation link
echo "<a href='confirmdelete.php?ohip=$ohip' onclick='if(confirm(\"Are you sure you want to delete this patient?\")) { this.form.submit(); }'>Delete Patient</a>";
echo "</form>";

// closing database connection
mysqli_close($connection);
?>

<!-- hyperlink to main menu -->
<p>
<br>
    <a href="mainmenu.php">Back to Main Menu</a>
</p>

</body>
</html>
