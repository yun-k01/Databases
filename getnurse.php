<!-- Programmer Name: 71-->
<head>
      	<title>Western Hospital</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="hospital.css">
</head>

<?php
include 'connectdb.php';
?>

<!-- listing nurses as radio buttons-->
<h1>Here are the Nurses:</h1>
<form method="post">
    <h3>Select a Nurse:</h3>
    <?php
    $nurseQuery = "SELECT nurseid, firstname, lastname FROM nurse";
    $nurseResult = mysqli_query($connection, $nurseQuery);

    while ($row = mysqli_fetch_assoc($nurseResult)) {
        $nurseID = $row['nurseid'];
        $fullName = $row['firstname'] . ' ' . $row['lastname'];
        echo "<input type='radio' name='selectnurse' value='$nurseID'> $fullName <br>";
    }

    mysqli_free_result($nurseResult);
    ?>
<input type="submit" value="Sort Doctors">
</form>

<?php
// ensure nurse was selected
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['selectnurse'])) {
    $nurseID = mysqli_real_escape_string($connection, $_POST['selectnurse']);

    // query = nurses data
    $query = "
	SELECT 
        n.firstname AS n_fname,
        n.lastname AS n_lname,
        d.firstname AS d_fname,
        d.lastname AS d_lname,
        wf.hours AS doc_hours,
        SUM(wf.hours) OVER (PARTITION BY n.nurseid) AS total_hours,
        s.firstname AS s_fname, 
        s.lastname AS s_lname
    FROM 
        workingfor wf
    JOIN 
        nurse n ON wf.nurseid = n.nurseid
    JOIN 
        doctor d ON wf.docid = d.docid
    LEFT JOIN
        nurse s ON n.reporttonurseid = s.nurseid 
    WHERE 
        n.nurseid = '$nurseID';

    ";

    $result = mysqli_query($connection, $query);
    // display if query issue
    if (!$result) {
        die("Error: " . mysqli_error($connection));
    }

    // display nurse data
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div>';
        echo '<br>';
        echo "<strong>Nurse: {$row['n_fname']} {$row['n_lname']}</strong>";
        echo "<li>Doctor: {$row['d_fname']} {$row['d_lname']}</li>";
        echo "<li>Hours Worked for Doctor: {$row['doc_hours']}</li>";
        echo "<li>Total Hours Worked: {$row['total_hours']}</li>";
        echo "<li>Supervisor: {$row['s_fname']} {$row['s_lname']}</li>";
        echo '</div>';
    }

    // disconnect from the database
    mysqli_free_result($result);
    mysqli_close($connection);
}
?>

<!-- hyperlink to main menu -->
<p>
<br>
    <a href="mainmenu.php">Back to Main Menu</a>
</p>
</body>
</html>    
