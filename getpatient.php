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
function imperialHeight($heightInMeters) {
    $inches = $heightInMeters * 39.3701; // converting m to inches
    $feet = floor($inches / 12); 
    $inches = round($inches % 12); 
    return "{$feet} ft {$inches} in";
}

// function to get imperial height
function imperialWeight($weightInKg) {
    $weightInPounds = $weightInKg * 2.20462; // 1 kg = 2.20462 lb
    return round($weightInPounds, 1);
}
?>

<!-- creating radio buttons to sort data-->
<h1>Here are the Patients:</h1>
<form method="get">
    <!-- option to sort by first or last name-->
    <h3>Order by:</h3> 
    <label>
        <input type="radio" name="orderBy" value="p.firstname" <?php echo isset($_GET['orderBy']) && $_GET['orderBy'] == 'p.firstname' ? 'checked' : ''; ?>> First Name
    </label>
    <label>
        <input type="radio" name="orderBy" value="p.lastname" <?php echo isset($_GET['orderBy']) && $_GET['orderBy'] == 'p.lastname' ? 'checked' : ''; ?>> Last Name
    </label>
    <br>
    <!-- option to sort in ascending or descending alphabetically-->
    <h3>Order Direction:</h3>
    <label>
        <input type="radio" name="orderDirection" value="ASC" <?php echo isset($_GET['orderDirection']) && $_GET['orderDirection'] == 'ASC' ? 'checked' : ''; ?>> Ascending
    </label>
    <label>
        <input type="radio" name="orderDirection" value="DESC" <?php echo isset($_GET['orderDirection']) && $_GET['orderDirection'] == 'DESC' ? 'checked' : '';?>> Descending
    </label>
    <br>
    <input type="submit" value="Sort Patients">
</form>

<?php
// setting orderBy and orderDirection parameters, defaulting ascending and by first name
$orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : 'p.firstname';
$orderDirection = isset($_GET['orderDirection']) ? $_GET['orderDirection'] : 'ASC';

// setting SQL query with given parameters
$query = "SELECT p.firstname AS p_fname, p.lastname AS p_lname, d.firstname AS d_fname, d.lastname AS d_lname, 
                 p.height AS p_height, p.weight AS p_weight
          FROM patient p 
          JOIN doctor d 
          ON p.treatsdocid = d.docid 
          ORDER BY $orderBy $orderDirection";
?>

<?php
// tell user is query failed
$result = mysqli_query($connection, $query);
if (!$result) {
    die("Database query failed.");
}

// display results for all patients
echo '<ul>';
while ($row = mysqli_fetch_assoc($result)) {
    // converting height and weight to imperial
    $heightImperial = imperialHeight($row['p_height']);
    $weightImperial = imperialWeight($row['p_weight']);
    
    // display a patients info
    echo '<div>';
    echo '<br>';
    echo "<strong>Patient: {$row['p_fname']} {$row['p_lname']}</strong>";
    echo "<li>Doctor: {$row['d_fname']} {$row['d_lname']}</li>";
    echo "<li>Metric Height: {$row['p_height']} m</li>";
    echo "<li>Imperial Height: {$heightImperial}</li>";
    echo "<li>Metric Weight: {$row['p_weight']} kgs</li>";
    echo "<li>Imperial Weight: {$weightImperial} lbs</li>";
    echo '</div>';
}
echo '</ul>';

// disconnect from database
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
