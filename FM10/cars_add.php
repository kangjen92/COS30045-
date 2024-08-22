<!DOCTYPE html>
<html lang="en">
<head> 
<meta charset="utf-8">
<meta name="description" content="Creating Web Applications Lab 10">
<meta name="keywords" content="PHP, MySql">
<title>Retrieving records to HTML</title>    
</head>
<body>
<h1>Creating Web Applications - Lab10</h1>
<?php
    require_once ("settings.php");  // connection info

    $conn = mysqli_connect($host, $user, $pwd, $sql_db);

    // Function to sanitize user input
function sanitise_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if the form data is set and sanitize the inputs
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$make = sanitise_input($_POST['carmake']);
$model = sanitise_input($_POST['carmodel']);
$price = sanitise_input($_POST['price']);
$yom = sanitise_input($_POST['yom']);

        // Initialize error message
        $errMsg = "";

        // Validate inputs
        if (empty($make)) {
            $errMsg .= "<p>You must enter the car maker name.</p>";
        } 
        else if (!preg_match("/^[a-zA-Z]*$/", $make)) {
            $errMsg .= "<p>Only alpha letters allowed in your car maker name.</p>";
        }

        if (empty($model)) {
            $errMsg .= "<p>You must enter the model name.</p>";
        } 
        else if (!preg_match("/^[a-zA-Z0-9 ]*$/", $model)) {
            $errMsg .= "<p>Only alpha characters or numbers allowed in your model name.</p>";
        }

        if (empty($price)) {
            $errMsg .= "<p>You must enter the price.</p>";
        } 
        else if (!preg_match("/^[0-9]*$/", $price)) {
            $errMsg .= "<p>Only numbers allowed in your price.</p>";
        }

        if (empty($yom)) {
            $errMsg .= "<p>You must enter the year of manufacture.</p>";
        } 
        else if (!preg_match("/^[0-9]*$/", $yom)) {
            $errMsg .= "<p>Only numbers allowed in your year of manufacture.</p>";
        }
    } 
    else {
        // Redirect to form if accessed directly
        header("location: searchcar.html");
    }

    // Display error if got and stop the execution
    if ($errMsg != "") 
    {
        echo $errMsg;
    } 
    else 
    {
    // Checks if connection is successful
    if (!$conn) {
        // Displays an error message
        echo "<p>Database connection failure</p>"; // not in production script
    } 
    else {
        // Check if the form data is set
            $sql_table = "cars";

            // Set up the SQL command to query or add data into the table
            $query = "insert into $sql_table (make, model, price, yom) values ('$make', '$model', '$price', '$yom')";

            // Execute the query - we should really check to see if the database exists first.
            $result = mysqli_query($conn, $query);

            // Checks if the execution was successful
            if (!$result) {
                echo "<p class=\"wrong\">Something is wrong with ", $query, "</p>";
                // Would not show in a production script
            } else {
                // Display an operation successful message
                echo "<p class=\"ok\">Successfully added New Car record</p>";
            } // End of successful query operation

            // Close the database connection
            mysqli_close($conn);
        } 
    } // End of successful database connection
?>
</body>
</html>



