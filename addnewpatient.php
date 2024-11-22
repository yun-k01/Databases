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

<!-- user inputs new patient's data-->
<h1>Add New Patient:</h1>
<form action="addnewpatient.php" method="post" enctype="multipart/form-data">
    New Patient's First Name: <input type="text" name="fName"><br>
    New Patient's Last Name: <input type="text" name="lName"><br>
    New Patient's OHIP number: <input type="text" name="ohip"><br>
    New Patient's Weight (kg): <input type="text" name="weight"><br>
    New Patient's Birthday (YYYY-MM-DD): <input type="text" name="bday"><br>
    New Patient's Height (m): <input type="text" name="height"><br>
    New Patient's Doctor: <br>
    <?php
    // lists all the doctors as radio buttons
    $doctorQuery = "SELECT docid, firstname, lastname FROM doctor";
    $result = mysqli_query($connection, $doctorQuery);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $docID = $row['docid'];
            $docName = $row['firstname'] . " " . $row['lastname'];
            echo "<input type='radio' name='docID' value='$docID' required> $docName<br>";
        }
    } else {
        echo "Error fetching doctors: " . mysqli_error($connection);
    }
    ?>
    <br>
    <input type="submit" value="Add New Patient">
</form>

<ol>
<?php
// ensure data is submitted before being processed
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ensure all fields are filled
    if (isset($_POST["fName"]) && isset($_POST["lName"]) && isset($_POST["ohip"]) && isset($_POST["weight"]) && isset($_POST["bday"]) && isset($_POST["height"]) && isset($_POST["docID"])) {
        
        // retrieving user data
        $fName = $_POST["fName"];
        $lName = $_POST["lName"];
        $ohip = $_POST["ohip"];
        $weight = $_POST["weight"];
        $bday = $_POST["bday"];
        $height = $_POST["height"];
        $docID = $_POST["docID"];

        // ensure OHIP number is unique
        $checkQuery = "SELECT COUNT(*) FROM patient WHERE ohip = '$ohip'";
        $result = mysqli_query($connection, $checkQuery);
        $row = mysqli_fetch_row($result);

        // if OHIP is not unique, return error
        if ($row[0] > 0) {
            echo "Error: Please enter a unique OHIP number.";
        } else {
            // insert data if OHIP is unique
            $query = "INSERT INTO patient (ohip, firstname, lastname, weight, birthdate, height, treatsdocid) 
                      VALUES ('$ohip', '$fName', '$lName', '$weight', '$bday', '$height', '$docID')";

            // tell user if query was successful
            if (!mysqli_query($connection, $query)) {
                die("Error: insert failed - " . mysqli_error($connection));
            } else {
                echo "Patient was added!";
            }
        }
    } else {
        echo "Error: Please fill in all required fields.";
    }
    // closing connection to database
    mysqli_close($connection);
}
?>
</ol>

<!-- hyperlink to main menu -->
<p>
<br>
    <a href="mainmenu.php">Back to Main Menu</a>
</p>

</body>
</html>
