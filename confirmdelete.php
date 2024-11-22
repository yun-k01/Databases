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

// check for ohip number
if (isset($_GET['ohip'])) {
    $ohip = $_GET['ohip']; // getting ohip number from deletepatient.php

    // perform deletion query
    $query = "DELETE FROM patient WHERE ohip = '$ohip'";

    // tell user if query was successful
    if (!mysqli_query($connection, $query)) {
      die("Error: Delete Failed". mysqli_error($connection));
    } else {
    echo "Success! Plug was pulled!";
    }

    // closing connection to database
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
