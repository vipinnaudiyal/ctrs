<?php
    $host="iitjdb.c34ko6kys3lo.us-east-1.rds.amazonaws.com";
    $port=3306;
    $socket="";
    $user="admin";
    $password="Admin123";
    $dbname="mydb";
    $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
    or die ('Could not connect to the database server' . mysqli_connect_error());

    $query = "SELECT EmpID, FirstName, LastName FROM employee_data";
    $stmt = $con->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $con->error);
    } else {
        $stmt->execute();
        $stmt->bind_result($field1name, $field2name,$field3name);
    while ($stmt->fetch()) {
        $options .= "<option value='" . $field1name. "'>" . $field2name . " " . $field3name. "</option>";

        }
   }
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
    <select id="dropdown" name="name_selecter">
    <option value="value" selected>Select Employee</option>
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

    recommend_Training_Location($emp_name); 
    echo '</div>';
    echo '<hr>';

    recommend_Training_division($emp_name);
    echo '</div>';
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
        $host="iitjdb.c34ko6kys3lo.us-east-1.rds.amazonaws.com";
        $port=3306;
        $socket="";
        $user="admin";
        $password="Admin123";
        $dbname="mydb";
        $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
        or die ('Could not connect to the database server' . mysqli_connect_error());

        $query = "SELECT EmpID,FirstName,LastName,Title,DOB,Supervisor,Division,GenderCode,MaritalDesc,`Performance Score`,`Current Employee Rating` FROM mydb.employee_data WHERE EmpID = '$emp_name'";
        $stmt = $con->prepare($query);
        if (!$stmt) {
            die("Prepare failed: " . $con->error);
        } else {
            $stmt->execute();
            $stmt->bind_result($field1name, $field2name,$field3name,$field4name,$field5name,$field6name,$field7name,$field8name,$field9name,$field10name,$field11name);
            echo "<h3>Selected employee's details</h3>";
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
                                <th>Ratings</th>
                            </tr>
                        </thead>
                ";
        while ($stmt->fetch()) {
            printf('<tr>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
            </tr>',
            $field1name, $field2name, $field3name, $field4name, $field5name, 
            $field6name, $field7name, $field8name, $field9name, $field10name, 
            $field11name);

        }
        }
                    echo '</table>';
                }


function recommend_Training_Location1($emp_name) { 
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
            echo "<h3>RECOMMENDATION 1 : Location Based training recommendations</h3>";
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
    echo '<br><h4 style="color:red">RECOMMENDATION 1 : No training is available for this employee based upon the location</h4><br>';
}
}

function recommend_Training_Location($emp_name) { 
    $host="iitjdb.c34ko6kys3lo.us-east-1.rds.amazonaws.com";
    $port=3306;
    $socket="";
    $user="admin";
    $password="Admin123";
    $dbname="mydb";
    $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
    or die ('Could not connect to the database server' . mysqli_connect_error());

    $hasRows = false;
    $count = 0;

    $query = "
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
    ";

    $stmt = $con->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $con->error);
    } else {
        $stmt->execute();
        $stmt->bind_result($field1name,$field2name,$field3name,$field4name);
  
    while ($stmt->fetch()) {
        $hasRows = true;
        if ($hasRows == true && $count == 0){
            echo "<h3>RECOMMENDATION 1 : Location Based training recommendations</h3>";
            echo "<table> 
                        <thead>
                            <tr>
                                <th>Training Program Name</th>
                                <th>Location</th>
                                <th>Training Duration (Days)</th>
                                <th>Training Cost</th>
                            </tr>
                        </thead>
                ";
                $count = $count+1;
        }
        printf('<tr>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
        </tr>',
        $field1name, $field2name, $field3name, $field4name, $field5name, 
        $field6name, $field7name, $field8name, $field9name);

        }
    }
    echo '</table>';
    if (!$hasRows){
        echo '<br><h4 style="color:red">RECOMMENDATION 1 : No training is available for this employee based upon the location</h4><br>';
    }

    }


function recommend_Training_division($emp_name) { 
    $host="iitjdb.c34ko6kys3lo.us-east-1.rds.amazonaws.com";
    $port=3306;
    $socket="";
    $user="admin";
    $password="Admin123";
    $dbname="mydb";
    $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
    or die ('Could not connect to the database server' . mysqli_connect_error());

    $hasRows = false;
    $count = 0;
    //$query = "SELECT EmpID,FirstName,LastName,Title,DOB,Supervisor,Division,GenderCode,MaritalDesc FROM mydb.employee_data ORDER BY EmpID DESC";
    $query = "
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
        WHERE EmpID = '$emp_name'
    ";

    $stmt = $con->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $con->error);
    } else {
        $stmt->execute();
        $stmt->bind_result($field1name,$field2name,$field3name,$field4name);
  
    while ($stmt->fetch()) {
        $hasRows = true;
        if ($hasRows == true && $count == 0){
            echo "<h3>RECOMMENDATION 2 : Division Based training recommendations</h3>";
            echo "<table> 
                        <thead>
                            <tr>
                                <th>Training Program Name</th>
                                <th>Location</th>
                                <th>Training Duration (Days)</th>
                                <th>Training Cost</th>
                            </tr>
                        </thead>
                ";
                $count = $count+1;
        }
        printf('<tr>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
        </tr>',
        $field1name, $field2name, $field3name, $field4name, $field5name, 
        $field6name, $field7name, $field8name, $field9name);

        }
    }
    echo '</table>';
    if (!$hasRows){
        echo '<br><h4 style="color:red">RECOMMENDATION 2 : No training is available for this employee based upon the division</h4><br>';
            }

    }

function recommend_Training_ratings($emp_name) { 
    $host="iitjdb.c34ko6kys3lo.us-east-1.rds.amazonaws.com";
    $port=3306;
    $socket="";
    $user="admin";
    $password="Admin123";
    $dbname="mydb";
    $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
    or die ('Could not connect to the database server' . mysqli_connect_error());

    $hasRows = false;
    $count = 0;
    //$query = "SELECT EmpID,FirstName,LastName,Title,DOB,Supervisor,Division,GenderCode,MaritalDesc FROM mydb.employee_data ORDER BY EmpID DESC";
    $query = "
         with training_program as (
        SELECT `EmpID`,`EmployeeStatus`,`EmployeeType`,`Division` FROM `employee_data` WHERE 
        `Current Employee Rating`<3 AND
        `EmployeeStatus` IN ('Active','Future Start','Leave of Absence')AND
        `EmployeeType` = 'Full-Time')
        
        select DISTINCT(t2.TrainingProgram),t3.Location,t3.`Training Duration(Days)`,t3.`Training Cost` from training_program t1 JOIN division_training_mapping t2 ON t1.Division = t2.DivisionName
        JOIN training_and_development_data t3 on t2.TrainingProgram = t3.`Training Program Name`
        WHERE EmpId = '$emp_name'
        GROUP by t2.TrainingProgram
    ";

    $stmt = $con->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $con->error);
    } else {
        $stmt->execute();
        $stmt->bind_result($field1name,$field2name,$field3name,$field4name);
  
    while ($stmt->fetch()) {
        $hasRows = true;
        if ($hasRows == true && $count == 0){
            echo "<h3>RECOMMENDATION 3 : Ratings Based training recommendations</h3>";
            echo "<table> 
                        <thead>
                            <tr>
                                <th>Training Program Name</th>
                                <th>Location</th>
                                <th>Training Duration (Days)</th>
                                <th>Training Cost</th>
                            </tr>
                        </thead>
                ";
                $count = $count+1;
        }
        printf('<tr>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
        </tr>',
        $field1name, $field2name, $field3name, $field4name, $field5name, 
        $field6name, $field7name, $field8name, $field9name);

        }
    }
    echo '</table>';
    if (!$hasRows){
        echo '<br><h4 style="color:red">RECOMMENDATION 3 : No training is available for this employee based upon the Ratings</h4><br>';
        echo 'Eligibility for this training:<br>
                1. Ratings < 3<br>
                2. Full-Time employee';
            }

    }

function recommend_Training_performers($emp_name) { 
    $host="iitjdb.c34ko6kys3lo.us-east-1.rds.amazonaws.com";
    $port=3306;
    $socket="";
    $user="admin";
    $password="Admin123";
    $dbname="mydb";
    $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
    or die ('Could not connect to the database server' . mysqli_connect_error());

    $hasRows = false;
    $count = 0;
    //$query = "SELECT EmpID,FirstName,LastName,Title,DOB,Supervisor,Division,GenderCode,MaritalDesc FROM mydb.employee_data ORDER BY EmpID DESC";
    $query = "with best_employees as (SELECT `EmpID`,`EmployeeStatus`,`EmployeeType`,`Division` FROM mydb.employee_data WHERE 
        `Current Employee Rating`>4 AND `EmployeeStatus` IN ('Active','Future Start','Leave of Absence')AND
        `EmployeeType` = 'Full-Time' AND
        `Performance Score` IN ('Fully Meets','Exceeds') AND 
        `Division` IN (SELECT DISTINCT(DivisionName) from mydb.division_training_mapping WHERE TrainingProgram != 'Leadership Development')
        )
        select DISTINCT(t2.TrainingProgram),t3.Location,t3.`Training Duration(Days)`,t3.`Training Cost`  from best_employees t1 JOIN mydb.division_training_mapping t2
        on t1.Division = t2.DivisionName 
        JOIN mydb.training_and_development_data t3 on t2.TrainingProgram = t3.`Training Program Name`
        WHERE EmpId = '$emp_name' GROUP by t2.TrainingProgram;
    ";

    $stmt = $con->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $con->error);
    } else {
        $stmt->execute();
        $stmt->bind_result($field1name,$field2name,$field3name,$field4name);
  
    while ($stmt->fetch()) {
        $hasRows = true;
        if ($hasRows == true && $count == 0){
            echo "<h3>RECOMMENDATION 4 : Recommendations for good performers</h3>";
            echo "<table> 
                        <thead>
                            <tr>
                                <th>Training Program Name</th>
                                <th>Location</th>
                                <th>Training Duration (Days)</th>
                                <th>Training Cost</th>
                            </tr>
                        </thead>
                ";
                $count = $count+1;
        }
        printf('<tr>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
        </tr>',
        $field1name, $field2name, $field3name, $field4name, $field5name, 
        $field6name, $field7name, $field8name, $field9name);

        }
    }
                echo '</table>';
    if (!$hasRows){
        echo '<br><h4 style="color:red">RECOMMENDATION 4 : No training is available for this employee based upon the Performance</h4><br>';
        echo 'Eligibility for this training:<br>
                1. Ratings > 4<br>
                2. Full-Time employee<br>
                3. Performance-> Exceeds or Fully-Meets';
            }

    }



function recommend_Training_similarity($emp_name) { 
    $host="iitjdb.c34ko6kys3lo.us-east-1.rds.amazonaws.com";
    $port=3306;
    $socket="";
    $user="admin";
    $password="Admin123";
    $dbname="mydb";
    $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
    or die ('Could not connect to the database server' . mysqli_connect_error());
    $hasRows = false;
    $count = 0;
    //$query = "SELECT EmpID,FirstName,LastName,Title,DOB,Supervisor,Division,GenderCode,MaritalDesc,`Performance Score`,`Current Employee Rating` FROM mydb.employee_data WHERE EmpID = '$emp_name'";
    $query = "
        with reference_employee_perf_ratings as 
        (SELECT * FROM mydb.employee_data WHERE 
        `Division`= (SELECT Division from mydb.employee_data WHERE EmpID = '$emp_name') AND
        `Performance Score` = (SELECT `Performance Score` from mydb.employee_data WHERE EmpID = '$emp_name') AND
        `Current Employee Rating` = (SELECT `Current Employee Rating` from mydb.employee_data where EmpID = '$emp_name')AND 
        EmpID != '$emp_name'),survey_score as (
        select `Employee ID` From mydb.employee_engagement_survey_data WHERE 
        `Engagement Score` = (SELECT `Engagement Score` FROM mydb.employee_engagement_survey_data WHERE `Employee ID` = '$emp_name') AND
        `Satisfaction Score` = (SELECT `Satisfaction Score` FROM mydb.employee_engagement_survey_data WHERE `Employee ID` = '$emp_name') AND
        `Employee ID` != '$emp_name')
        SELECT EmpID,FirstName,LastName,Title,DOB,Supervisor,Division,GenderCode,MaritalDesc,`Performance Score`,`Current Employee Rating` FROM reference_employee_perf_ratings t1 JOIN survey_score t2 ON t1.EmpID = t2.`Employee ID`;";
    
    $stmt = $con->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $con->error);
    } else {
        $stmt->execute();
        $stmt->bind_result($field1name, $field2name,$field3name,$field4name,$field5name,$field6name,$field7name,$field8name,$field9name,$field10name,$field11name);
    while ($stmt->fetch()) {
        $hasRows = true;
        if ($hasRows == true && $count == 0){
            echo "<h3>RECOMMENDATION 5 : Similarity based recommendations</h3>";
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
                                <th>Ratings</th>
                            </tr>
                        </thead>
                ";
            $count = $count+1;
        };
        printf('<tr>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
        </tr>',
        $field1name, $field2name, $field3name, $field4name, $field5name, 
        $field6name, $field7name, $field8name, $field9name, $field10name, 
        $field11name);

    }
    }
                echo '</table>';
//////
if ($hasRows){
$query = "SELECT `Training Program Name`,`Location`,`Training Duration(Days)`,`Training Cost` FROM `training_and_development_data` WHERE `Employee ID` = '$emp_name';";
        $stmt = $con->prepare($query);
        if (!$stmt) {
            die("Prepare failed: " . $con->error);
        } else {
            $stmt->execute();
            $stmt->bind_result($sfield1name,$sfield2name,$sfield3name,$sfield4name);
            echo "<h3>Trainings recommended to the listed employees</h3>";
            echo "<table> 
                        <thead>
                            <tr>
                                <th>Training Program Name</th>
                                <th>Location</th>
                                <th>Training Duration (Days)</th>
                                <th>Training Cost</th>
                            </tr>
                        </thead>
                ";
    
        while ($stmt->fetch()) { 
            printf('<tr>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
            </tr>',
            $sfield1name, $sfield2name, $sfield3name, $sfield4name, $sfield5name, 
            $sfield6name, $sfield7name, $sfield8name, $sfield9name);
    
        }
        }
        echo '</table>';
    }
     if (!$hasRows){
        echo '<br><h4 style="color:red">RECOMMENDATION 5 : No employee matches the selected employee</h4><br>';
        echo 'Matching Criteria:<br>
                1. Same Performance <br>
                2. Same Ratings<br>
                3. Same Engagment score <br>
                4. Same Satisfaction score';
     }
    }

?>

