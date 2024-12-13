<!DOCTYPE html>
   <head>
    <title>IIT</title>
    <a href="index.php"><input type = "submit" name = "back" value = "back" style = " border-radius: 14px;border-width: thin;"></a>
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
                    <h3 style = "text-align: center;">IIT JODHPUR, Training Programs</h>
                    
                </div>
                <div id = "first">
                    <!--Creating login form--> 

                    <form method = "POST">
                        <br><br>
                        <input type = "submit" name = "training_list" value = "Training Programs" class = "navigationButton">
                        <input type = "submit" name = "show_all_training_data" value = "Show Training Records" class = "navigationButton">
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
        if(array_key_exists('show_all_training_data', $_POST)) { 
            training_history(); 
        }
        if(array_key_exists('training_list', $_POST)) { 
            training_material(); 
        }

        //Definition of functions 
        function training_history() { 
            $host="iitjdb.c34ko6kys3lo.us-east-1.rds.amazonaws.com";
            $port=3306;
            $socket="";
            $user="admin";
            $password="Admin123";
            $dbname="mydb";
            $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
            or die ('Could not connect to the database server' . mysqli_connect_error());
        
            //$query = "SELECT EmpID,FirstName,LastName,Title,DOB,Supervisor,Division,GenderCode,MaritalDesc FROM mydb.employee_data ORDER BY EmpID DESC";
            $query = "SELECT `Employee ID`,`Training Date`,`Training Program Name`,`Training Type`,`Training Outcome`,`Location`,`Trainer`,`Training Duration(Days)`,`Training Cost` FROM mydb.training_and_development_data";

            $stmt = $con->prepare($query);
            if (!$stmt) {
                die("Prepare failed: " . $con->error);
            } else {
                $stmt->execute();
                $stmt->bind_result($field1name,$field2name,$field3name,$field4name,$field5name,$field6name,$field7name,$field8name,$field9name);
                echo "<h3>Employee records</h3>";
                echo "<table> 
                        <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Training Date</th>
                                    <th>Training Program Name</th>
                                    <th>Training Type</th>
                                    <th>Training Outcome</th>
                                    <th>Location</th>
                                    <th>Trainer</th>
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
                    <td>%s</td>
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
                    }
    function training_material() { 
        $host="iitjdb.c34ko6kys3lo.us-east-1.rds.amazonaws.com";
        $port=3306;
        $socket="";
        $user="admin";
        $password="Admin123";
        $dbname="mydb";
        $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
        or die ('Could not connect to the database server' . mysqli_connect_error());
    
        //$query = "SELECT EmpID,FirstName,LastName,Title,DOB,Supervisor,Division,GenderCode,MaritalDesc FROM mydb.employee_data ORDER BY EmpID DESC";
        $query = "SELECT DISTINCT(`Training Program Name`),`Training Cost`,`Training Duration(Days)`,`Trainer`,`Location` FROM `training_and_development_data` GROUP BY `Training Program Name`;";

        $stmt = $con->prepare($query);
        if (!$stmt) {
            die("Prepare failed: " . $con->error);
        } else {
            $stmt->execute();
            $stmt->bind_result($field1name,$field2name,$field3name,$field4name,$field5name);
            echo "<h3>Employee records</h3>";
            echo "<table> 
                        <thead>
                            <tr>
                                <th>Training Program Name</th>
                                <th>Location</th>
                                <th>Trainer</th>
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
                <td>%s</td>
            </tr>',
            $field1name, $field2name, $field3name, $field4name, $field5name, 
            $field6name, $field7name, $field8name, $field9name);
    
        }
        }
                    echo '</table>';
                }
    ?> 



