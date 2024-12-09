<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "bdm_project";


$conn = new mysqli($host, $username, $password, $database);
// Assuming a connection to the database is already established
//"SELECT FirstName,LastName FROM employee_data";
$sql = "SELECT EmpID, FirstName, LastName FROM employee_data"; // Example SQL query
$result = $conn->query($sql);

$options = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Populate options dynamically
        $options .= "<option value='" . $row["EmpID"] . "'>" . $row["FirstName"] . " " . $row["LastName"] . "</option>";
    }
} else {
    $options = "<option value=''>No employees found</option>";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dropdown from Database</title>
    <style>
        select {
            padding: 6px;
            font-size: 14px;
            width: 242px;
            height: 29px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<form action="" method="POST">
    <label for="dropdown">Select employee:</label>
    <select id="dropdown" name="name_selecter">
        <?php echo $options; ?>
    </select>
    <input  style = "height: 28px;" type = "submit" name = "recommend" value = "Recommend Programs">
    </form>
</body>
</html>
<?php



if(array_key_exists('recommend', $_POST)) { 
    $emp_name = $_POST['name_selecter'];
    recommend_Training($emp_name); 
        }
//Definition of functions 
function recommend_Training($emp_name) { 
    $con = mysqli_connect("localhost", "root","","bdm_project"); #Connection string
    if(mysqli_connect_errno())
    {
        echo "Failed to connect:" . mysqli_connect_errno();
    }
    $result = mysqli_query($con,"
    with training_program as (

        SELECT DISTINCT(`Training Program Name`),Location,`Training Duration(Days)`,
        `Training Cost` 
        FROM `training_and_development_data`
        GROUP BY `Training Program Name`),


        valid_employee as (
            SELECT EmpID,FirstName,LastName FROM employee_data
            WHERE EmployeeStatus = 'Active'
        )
        select `Training Program Name`,`Location`,`Training Duration(Days)`,`Training Cost` from training_program WHERE
        Location = (SELECT State From employee_data WHERE
        EmpID = '$emp_name');
    ");

    if ($result->num_rows > 0){
        while ($row = $result->fetch_assoc()) {
            echo "<h3>Location Based training recommendations</h3>";
            echo "<table> 
                    <thead>
                        <tr>
                            <th>Recommended Training</th>
                            <th>Location</th>
                            <th>Duration</th>
                            <th>Cost</th>
                        </tr>
                    </thead>
                    ";

                    $field1name = $row["Training Program Name"];
                    $field2name = $row["Location"];
                    $field3name = $row["Training Duration(Days)"]; 
                    $field4name = $row["Training Cost"]; 
                        
                    echo ' <tr>
                            <td>'.$field1name.'</td>
                            <td>'.$field2name.'</td> 
                            <td>'.$field3name.'</td> 
                            <td>'.$field4name.'</td> 
                            </tr>
                        ';
                } 
                echo '</table>';
            }
else{
    echo '<br><h4>No training is available for this employee based upon the location</h4><br>';
}
}


?>

