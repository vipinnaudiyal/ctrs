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
    <a href="index.php"><input type = "submit" name = "back" value = "back" style = " border-radius: 14px;border-width: thin;"></a><br><br>
    <title>Dropdown from Database</title>
    <style>
        select {
            padding: 6px;
            font-size: 14px;
            width: 242px;
            height: 33px;
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
<br>
<form action="" method="POST">
    <label for="dropdown">Select Employee</label><br><br>
    <select id="dropdown" name="name_selecter">
        <?php echo $options; ?>
    </select>
    <input  style = "height: 35px;" type = "submit" name = "recommend" value = "Recommend Programs">
    </form>
</body>
</html>
<?php

if(array_key_exists('recommend', $_POST)) { 
    $emp_name = $_POST['name_selecter'];
    retrive_details_of_selected_employee($emp_name);
    echo '<hr>';
    recommend_Training($emp_name); 
    echo '<hr>';
    recommend_Training_division($emp_name);
    echo '<hr>';
    recommend_Training_ratings($emp_name);
    echo '<hr>';
    recommend_Training_performers($emp_name);
    echo '<hr>';
    recommend_Training_similarity($emp_name);
    echo '<hr>';
        }
//Definition of functions
function retrive_details_of_selected_employee($emp_name) { 
    $con = mysqli_connect("localhost", "root","","bdm_project"); #Connection string
    if(mysqli_connect_errno())
    {
        echo "Failed to connect:" . mysqli_connect_errno();
    }
    $result = mysqli_query($con,"SELECT * FROM employee_data WHERE EmpID = '$emp_name'");
            echo "<h3>Employee records</h3>";
            echo "<table> 
                    <thead>
                                <tr>
                                    <th>EmpID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Title</th>
                                    <th>DOB</th>
                                    <th>Manager</th>
                                    <th>Division</th>
                                    <th>Gender</th>
                                    <th>Marital Status</th>
                                    <th>Performance Score</th>
                                    <th>Tratings</th>
                                </tr>
                            </thead>
                    ";
                while ($row = $result->fetch_assoc()) {
                    $field1name = $row["EmpID"];
                    $field2name = $row["FirstName"];
                    $field3name = $row["LastName"];
                    $field4name = $row["Title"];
                    $field5name = $row["DOB"];
                    $field6name = $row["Supervisor"];
                    $field7name = $row["Division"]; 
                    $field8name = $row["GenderCode"];
                    $field9name = $row["MaritalDesc"];    
                    $field10name = $row["Performance Score"];
                    $field11name = $row["Current Employee Rating"];       
                    echo ' <tr>
                            <td>'.$field1name.'</td>
                            <td>'.$field2name.'</td> 
                            <td>'.$field3name.'</td> 
                            <td>'.$field4name.'</td>
                            <td>'.$field5name.'</td> 
                            <td>'.$field6name.'</td> 
                            <td>'.$field7name.'</td> 
                            <td>'.$field8name.'</td> 
                            <td>'.$field9name.'</td>
                            <td>'.$field10name.'</td> 
                            <td>'.$field11name.'</td>
                            </tr>
                        ';
                } 
                echo '</table>';
            }


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
                            <th>Duration (Days)</th>
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

function recommend_Training_division($emp_name) { 
    $con = mysqli_connect("localhost", "root","","bdm_project"); #Connection string
    if(mysqli_connect_errno())
    {
        echo "Failed to connect:" . mysqli_connect_errno();
    }
    $result = mysqli_query($con,"
        with training_program as (
        SELECT DISTINCT(`Training Program Name`) ProgramName,Location,`Training Duration(Days)` Duration,`Training Cost` Cost FROM `training_and_development_data`
        GROUP BY `Training Program Name`),
        valid_employee as (
            SELECT EmpID,FirstName,LastName,DepartmentType,Division FROM employee_data
            WHERE EmployeeStatus = 'Active'
        ),
        mapping_divison_training as (
            SELECT t1.EmpID,t1.FirstName, t1.Division,t2.TrainingProgram FROM valid_employee t1 JOIN division_training_mapping t2 ON
            t1.Division = t2.DivisionName
            )
        select TrainingProgram,t4.Location,t4.Duration,t4.Cost FROM mapping_divison_training t3
        JOIN training_program t4 ON t3.TrainingProgram = t4.ProgramName
        WHERE EmpID = '$emp_name';
    ");

    if ($result->num_rows > 0){
        echo "<h3>Division Based training recommendations</h3>";
        echo "<table> 
                <thead>
                    <tr>
                        <th>Recommended Training</th>
                        <th>Location</th>
                        <th>Duration (Days)</th>
                        <th>Cost</th>
                    </tr>
                </thead>
                ";
        while ($row = $result->fetch_assoc()) {
                    $field1name = $row["TrainingProgram"];
                    $field2name = $row["Location"];
                    $field3name = $row["Duration"]; 
                    $field4name = $row["Cost"]; 
                        
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
    echo '<br><h4>No training is available for this employee based upon the division</h4><br>';
}
}

function recommend_Training_ratings($emp_name) { 
    $con = mysqli_connect("localhost", "root","","bdm_project"); #Connection string
    if(mysqli_connect_errno())
    {
        echo "Failed to connect:" . mysqli_connect_errno();
    }
    $result = mysqli_query($con,"
      with training_program as (
        SELECT `EmpID`,`EmployeeStatus`,`EmployeeType`,`Division` FROM `employee_data` WHERE 
        `Current Employee Rating`<3 AND
        `EmployeeStatus` IN ('Active','Future Start','Leave of Absence')AND
        `EmployeeType` = 'Full-Time')
        
        select DISTINCT(t2.TrainingProgram),t3.Location,t3.`Training Duration(Days)`,t3.`Training Cost` from training_program t1 JOIN division_training_mapping t2 ON t1.Division = t2.DivisionName
        JOIN training_and_development_data t3 on t2.TrainingProgram = t3.`Training Program Name`
        WHERE EmpId = '$emp_name'
        GROUP by t2.TrainingProgram;

    ");

    if ($result->num_rows > 0){
        echo "<h3>Ratings Based training recommendations</h3>";
        echo "<table> 
                <thead>
                    <tr>
                        <th>Recommended Training</th>
                        <th>Location</th>
                        <th>Duration (Days)</th>
                        <th>Cost</th>
                    </tr>
                </thead>
                ";
        while ($row = $result->fetch_assoc()) {
                    $field1name = $row["TrainingProgram"];
                    $field2name = $row["Location"];
                    $field3name = $row["Training Duration(Days)"]; 
                    $field4name = $row["Training Cost"]; ; 
                        
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
    echo '<br><h4>No training is available for this employee based upon the Ratings</h4><br>';
    echo 'Eligibility for this training:<br>
            1. Ratings < 3<br>
            2. Full-Time employee';
}
}
function recommend_Training_performers($emp_name) { 
    $con = mysqli_connect("localhost", "root","","bdm_project"); #Connection string
    if(mysqli_connect_errno())
    {
        echo "Failed to connect:" . mysqli_connect_errno();
    }
    $result = mysqli_query($con,"
    with best_employees as (
        SELECT `EmpID`,`EmployeeStatus`,`EmployeeType`,`Division` FROM `employee_data` WHERE 
        `Current Employee Rating`>4 AND
        `EmployeeStatus` IN ('Active','Future Start','Leave of Absence')AND
        `EmployeeType` = 'Full-Time' AND
        `Performance Score` IN ('Fully Meets','Exceeds') AND 
        `Division` IN (SELECT DISTINCT(DivisionName) from division_training_mapping 		WHERE TrainingProgram != 'Leadership Development')
        )
        select DISTINCT(t2.TrainingProgram),t3.Location,t3.`Training Duration(Days)`,t3.`Training Cost`  from best_employees t1 JOIN division_training_mapping t2
        on t1.Division = t2.DivisionName 
        JOIN training_and_development_data t3 on t2.TrainingProgram = t3.`Training Program Name`
        WHERE EmpId = '$emp_name' GROUP by t2.TrainingProgram;

    ");

    if ($result->num_rows > 0){
        echo "<h3>Ratings Based training recommendations</h3>";
        echo "<table> 
                <thead>
                    <tr>
                        <th>Recommended Training</th>
                        <th>Location</th>
                        <th>Duration (Days)</th>
                        <th>Cost</th>
                    </tr>
                </thead>
                ";
        while ($row = $result->fetch_assoc()) {
                    $field1name = $row["TrainingProgram"];
                    $field2name = $row["Location"];
                    $field3name = $row["Training Duration(Days)"]; 
                    $field4name = $row["Training Cost"]; ; 
                        
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
    echo '<br><h4>No training is available for this employee based upon the Performance</h4><br>';
    echo 'Eligibility for this training:<br>
            1. Ratings > 4<br>
            2. Full-Time employee<br>
            3. Performance-> Exceeds or Fully-Meets';
}
}

function recommend_Training_similarity($emp_name) { 
    $con = mysqli_connect("localhost", "root","","bdm_project"); #Connection string
    if(mysqli_connect_errno())
    {
        echo "Failed to connect:" . mysqli_connect_errno();
    }
    $result = mysqli_query($con,"
    #below is to find the employees having same division, ratings & performance 
        with reference_employee_perf_ratings as 
        (SELECT * FROM `employee_data` WHERE 
        `Division`= (SELECT Division from employee_data WHERE EmpID = '$emp_name') AND
        `Performance Score` = (SELECT `Performance Score` from employee_data WHERE EmpID = '$emp_name') AND
        `Current Employee Rating` = (SELECT `Current Employee Rating` from employee_data where EmpID = '$emp_name')AND 
        EmpID != '$emp_name'),

        #below is to find the employees having same engagment score & satisfaction score as select employee
        survey_score as (
        select `Employee ID` From employee_engagement_survey_data WHERE 
        `Engagement Score` = (SELECT `Engagement Score` FROM employee_engagement_survey_data WHERE `Employee ID` = '$emp_name') AND
        `Satisfaction Score` = (SELECT `Satisfaction Score` FROM employee_engagement_survey_data WHERE `Employee ID` = '$emp_name') AND
        `Employee ID` != '$emp_name')

        #below is to Employee Id of the similar employees
        SELECT * FROM reference_employee_perf_ratings t1 JOIN survey_score t2 ON t1.EmpID = t2.`Employee ID`;
    ");

    if ($result->num_rows > 0){
        echo "<h3>Ratings Based training recommendations</h3>";
        echo "<table> 
                    <thead>
                                <tr>
                                    <th>EmpID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Title</th>
                                    <th>DOB</th>
                                    <th>Manager</th>
                                    <th>Division</th>
                                    <th>Gender</th>
                                    <th>Marital Status</th>
                                    <th>Performance Score</th>
                                    <th>Tratings</th>
                                </tr>
                            </thead>
                    ";
                while ($row = $result->fetch_assoc()) {
                    $field1name = $row["EmpID"];
                    $field2name = $row["FirstName"];
                    $field3name = $row["LastName"];
                    $field4name = $row["Title"];
                    $field5name = $row["DOB"];
                    $field6name = $row["Supervisor"];
                    $field7name = $row["Division"]; 
                    $field8name = $row["GenderCode"];
                    $field9name = $row["MaritalDesc"];    
                    $field10name = $row["Performance Score"];
                    $field11name = $row["Current Employee Rating"];       
                    echo ' <tr>
                            <td>'.$field1name.'</td>
                            <td>'.$field2name.'</td> 
                            <td>'.$field3name.'</td> 
                            <td>'.$field4name.'</td>
                            <td>'.$field5name.'</td> 
                            <td>'.$field6name.'</td> 
                            <td>'.$field7name.'</td> 
                            <td>'.$field8name.'</td> 
                            <td>'.$field9name.'</td>
                            <td>'.$field10name.'</td> 
                            <td>'.$field11name.'</td>
                            </tr>
                        ';
                } 
                echo '</table>';
//////////
$result = mysqli_query($con,"
       SELECT `Training Program Name`,`Location`,`Training Duration(Days)`,`Training Cost` FROM `training_and_development_data` WHERE `Employee ID` = '$emp_name';
    ");

    if ($result->num_rows > 0){
        while ($row = $result->fetch_assoc()) {
            echo "<h3>Training Recommended to the listed employees</h3>";
            echo "<table> 
                    <thead>
                        <tr>
                            <th>Recommended Training</th>
                            <th>Location</th>
                            <th>Duration (Days)</th>
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

//////////




            }}
else{
    echo '<br><h4>No employee matches the selected employee</h4><br>';
    echo 'Matching Criteria:<br>
            1. Same Performance <br>
            2. Same Ratings<br>
            3. Same Engagment score <br>
            4. Same Satisfaction score';
}
}


?>

