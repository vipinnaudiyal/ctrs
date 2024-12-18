<?php
$con = mysqli_connect("localhost", "root","","bdm_project"); #Connection string
if(mysqli_connect_errno())
{
    echo "Failed to connect:" . mysqli_connect_errno();
}
else{
    //echo "Connected to the DB";
}
?>
<!DOCTYPE html>
   <head>
    <title>IIT</title>
    <a href="index.php"><input type = "submit" name = "back" value = "back" style = " border-radius: 14px;border-width: thin;"></a><br>
    <style>
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
        .navigationButton{
            width:170px;
            position: relative;
            top: 0px;
            right: 0px;
            background-color: whitesmoke;
            border-radius: 30px;
            height: 40px;}
    </style>
    </head>
    <body>
        <div class = "wrapper">
            <div class = "login_box">
                <div class = 'login_header'>
                    <h3>IIT JODHPUR</h3>
                    <h3>Welcome to Employee's Section</h><br><br>
                </div>
                <div id = "first">
                    <!--Creating login form--> 

                    <form method = "POST">
                        <input type ="text" name = "fname" placeholder = "First Name" value = "">
                        <input type ="text" name = "lname" placeholder = "Last Name" value = "">
                        <input type ="text" name = "gender" placeholder = "Gender" value = "Male">
                        <input type ="text" name = "maritalstatus" placeholder = "Marital Status" value = "Married">
                        <div style = "width:100%">
                        <br>
                        <input type = "submit" name = "insertRecord" value = "Insert Data"class = "navigationButton" style = "width:100px;" >
                        <br><br>
                        <hr>
                        <br>
                        <input type = "submit" name = "employeeDetails" value = "Show Employees Detail" class = "navigationButton">
                        <br>
                        <br>
                        </div>
                        <br> 
                    </form>
                </div>
            </section>
            </div>
        </div>
    </body>
</html>

<?php   //function calling
        if(array_key_exists('employeeDetails', $_POST)) { 
            employeeDetails(); 
        }
        if(array_key_exists('training_list', $_POST)) { 
            training_material(); 
        }
        if(array_key_exists('insertRecord', $_POST)) { 
            insertRecord(); 
        } 

        //Definition of functions 

        function insertRecord() { 
            
            $fname = strip_tags($_POST['fname']);
            $lname = strip_tags($_POST['lname']);
            $gender = strip_tags($_POST['gender']);
            $maritalstatus = strip_tags($_POST['maritalstatus']);
            //$con = mysqli_connect("localhost", "root","","bdm_project"); #Connection string

            if (empty($fname) || empty($lname) || empty($gender) || empty($maritalstatus)) {
                echo "All fields are required. Please fill out all the fields.";
                exit;
            }
            #Building value Randomly using DB
            $empID = mysqli_query($con,"SELECT max(EmpID) as newemp FROM employee_data")->fetch_assoc()["newemp"]+1;
            $startDate = mysqli_query($con,"SELECT StartDate FROM employee_data ORDER BY RAND()LIMIT 1")->fetch_assoc()["StartDate"];
            $Title = mysqli_query($con,"SELECT Title FROM employee_data ORDER BY RAND()LIMIT 1")->fetch_assoc()["Title"];
            $Supervisor = mysqli_query($con,"SELECT Supervisor FROM employee_data ORDER BY RAND()LIMIT 1")->fetch_assoc()["Supervisor"];
            $ADEmail = $fname.".".$lname."@bilearner.com";
            $BusinessUnit = mysqli_query($con,"SELECT BusinessUnit FROM employee_data ORDER BY RAND()LIMIT 1")->fetch_assoc()["BusinessUnit"];
            $EmployeeStatus = mysqli_query($con,"SELECT EmployeeStatus FROM employee_data ORDER BY RAND()LIMIT 1")->fetch_assoc()["EmployeeStatus"];
            $EmployeeType = mysqli_query($con,"SELECT EmployeeType FROM employee_data ORDER BY RAND()LIMIT 1")->fetch_assoc()["EmployeeType"];
            $PayZone = mysqli_query($con,"SELECT PayZone FROM employee_data ORDER BY RAND()LIMIT 1")->fetch_assoc()["PayZone"];
            $EmployeeClassificationType = mysqli_query($con,"SELECT EmployeeClassificationType FROM employee_data ORDER BY RAND()LIMIT 1")->fetch_assoc()["EmployeeClassificationType"];
            $TerminationType = mysqli_query($con,"SELECT TerminationType FROM employee_data ORDER BY RAND()LIMIT 1")->fetch_assoc()["TerminationType"];
            $TerminationDescription = mysqli_query($con,"SELECT TerminationDescription FROM employee_data ORDER BY RAND()LIMIT 1")->fetch_assoc()["TerminationDescription"];
            $DepartmentType = mysqli_query($con,"SELECT DepartmentType FROM employee_data ORDER BY RAND()LIMIT 1")->fetch_assoc()["DepartmentType"];
            $Division = mysqli_query($con,"SELECT Division FROM employee_data ORDER BY RAND()LIMIT 1")->fetch_assoc()["Division"];
            $DOB = mysqli_query($con,"SELECT DOB FROM employee_data ORDER BY RAND()LIMIT 1")->fetch_assoc()["DOB"];
            $State = mysqli_query($con,"SELECT `State` FROM employee_data ORDER BY RAND()LIMIT 1")->fetch_assoc()["State"];
            $JobFunctionDescription = mysqli_query($con,"SELECT JobFunctionDescription FROM employee_data ORDER BY RAND()LIMIT 1")->fetch_assoc()["JobFunctionDescription"];
            $LocationCode = mysqli_query($con,"SELECT LocationCode FROM employee_data ORDER BY RAND()LIMIT 1")->fetch_assoc()["LocationCode"];
            $RaceDesc = mysqli_query($con,"SELECT RaceDesc FROM employee_data ORDER BY RAND()LIMIT 1")->fetch_assoc()["RaceDesc"];
            $PerformanceScore = mysqli_query($con,"SELECT `Performance Score` FROM employee_data ORDER BY RAND()LIMIT 1")->fetch_assoc()["Performance Score"];
            $CurrentEmployeeRating = mysqli_query($con,"SELECT `Current Employee Rating` FROM employee_data ORDER BY RAND()LIMIT 1")->fetch_assoc()["Current Employee Rating"];
            

            $query = mysqli_query($con,"INSERT INTO employee_data VALUES('$empID','$fname','$lname',
            '$startDate',NULL,'$Title','$Supervisor','$ADEmail','$BusinessUnit','$EmployeeStatus','$EmployeeType','$PayZone',
            '$EmployeeClassificationType','$TerminationType','$TerminationDescription','$DepartmentType','$Division','$DOB','$State',
            '$JobFunctionDescription','$gender','$LocationCode','$RaceDesc','$maritalstatus','$PerformanceScore','$CurrentEmployeeRating')
            ");  
            echo "Database updated successfully" ;  
            } 


        function employeeDetails() { 
            $con = mysqli_connect("localhost", "root","","bdm_project"); #Connection string

            if(mysqli_connect_errno())
            {
                echo "Failed to connect:" . mysqli_connect_errno();
            }
            $result = mysqli_query($con,"SELECT * FROM employee_data ORDER BY EmpID DESC");
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
       
            function training_material() { 
                $con = mysqli_connect("localhost", "root","","bdm_project"); #Connection string
                if(mysqli_connect_errno())
                {
                    echo "Failed to connect:" . mysqli_connect_errno();
                }
                $result = mysqli_query($con,'SELECT DISTINCT(`Training Program Name`),`Training Cost`,`Training Duration(Days)`,`Trainer` FROM `training_and_development_data` GROUP BY `Training Program Name`;');
                //$result = mysqli_query($con,"SELECT * FROM training_and_development_data");
                
                echo "<h3>List of trainings</h3>";
                echo "<table> 
                        <thead>
                                    <tr>
                                        <th>Training Program Name</th>
                                        <th>Trainer</th>
                                        <th>Training Duration (Days)</th>
                                        <th>Training Cost</th>
                                    </tr>
                                </thead>
                        ";
                    while ($row = $result->fetch_assoc()) {
                        $field3name = $row["Training Program Name"];
                        $field7name = $row["Trainer"]; 
                        $field8name = $row["Training Duration(Days)"];
                        $field9name = $row["Training Cost"];        
                        echo ' <tr>
                                <td>'.$field3name.'</td> 
                                <td>'.$field7name.'</td> 
                                <td>'.$field8name.'</td> 
                                <td>'.$field9name.'</td>
                                </tr>
                            ';
                    } 
                    echo '</table>';
                }
    ?> 



