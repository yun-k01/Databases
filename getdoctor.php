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
<!-- creating radio buttons to filter for doctors with and without patients -->
<h1>Here are the Doctors:</h1>
<form method="get">
    <h3>Filter:</h3>
    <label>
    <input type="radio" name="filter" value="patients" <?php echo isset($_GET['orderBy']) && $_GET['filter'] == 'patients' ? 'checked' : ''; ?>> Doctors with Patients
    </label>
    <label>
	<input type="radio" name="filter" value="no_patients" <?php echo isset($_GET['orderBy']) && $_GET['filter'] == 'no_patients' ? 'checked' : ''; ?>> Doctors without Patients
    </label>
    <br>
    <input type="submit" value="Sort Doctors">
</form>

<?php
// filter from query parameters, default showing doctors with patients
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'patients';

// SQL query depends on parameter
if ($filter === 'patients') {
    $query = "SELECT docid, d.firstname AS d_fname, d.lastname AS d_lname, p.firstname AS p_fname, p.lastname AS p_lname
        FROM doctor d
        LEFT JOIN patient p ON d.docid = p.treatsdocid
        WHERE p.treatsdocid IS NOT NULL
        ORDER BY d.firstname";
} else {
    $query = "SELECT docid, d.firstname AS d_fname, d.lastname AS d_lname, p.firstname AS p_fname, p.lastname AS p_lname
        FROM doctor d
        LEFT JOIN patient p ON d.docid = p.treatsdocid
        WHERE p.treatsdocid IS NULL
        ORDER BY d.firstname";
}
?>

<?php
// check if query was successful
$result = mysqli_query($connection, $query);
if (!$result) {
    die("Error: " . mysqli_error($connection));
}

// display doctors
echo '<ul>';
$currentDoctorId = null; // variable to keep track of current doc
while ($row = mysqli_fetch_assoc($result)) {
    // check if new doc
    if ($currentDoctorId !== $row['docid']) {
        // close previous doc's patient list
        if ($currentDoctorId !== null) {
            echo '</ul>'; 
            echo '</div>'; 
        }
        
        // update currentDoctorId
        $currentDoctorId = $row['docid'];
        
        // display the patients as list
        echo '<div>';
        echo '<br>';
        echo "<strong>Doctor: {$row['d_fname']} {$row['d_lname']}</strong>";
        echo "<li>Patients:</li>";
        echo '<ul>'; // start list for patient names
        echo '<div>';
    }
    
    // list patient names or say "No patients"
    if ($row['p_fname'] && $row['p_lname']) {
        echo "<li>{$row['p_fname']} {$row['p_lname']}</li>";
    } else {
        echo "<li>No patients</li>";
        echo "<li>Doctor ID: {$row['docid']}</li>";
    }
}

// close last doctors list
if ($currentDoctorId !== null) {
    echo '</ul>';
    echo '</div>';
}

echo '</ul>';

// close connection to database
mysqli_free_result($result);
mysqli_close($connection);
?>

<!-- hyperlink to main menu -->
<p>
<br>
<a href="mainmenu.php">Back to Main Menu</a>
</p>

</body>
</html>
