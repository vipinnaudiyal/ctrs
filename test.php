<?php
$host="iitjdb.c34ko6kys3lo.us-east-1.rds.amazonaws.com";
    $port=3306;
    $socket="";
    $user="admin";
    $password="Admin123";
    $dbname="mydb";
    $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
    or die ('Could not connect to the database server' . mysqli_connect_error());

    $query = "SELECT EmpID,FirstName,LastName,Title,DOB,Supervisor,Division,GenderCode,MaritalDesc,`Performance Score`,`Current Employee Rating` FROM mydb.employee_data ORDER BY EmpID DESC";
    $stmt = $con->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $con->error);
    } else {
        $stmt->execute();
        $stmt->bind_result($field1name, $field2name,$field3name,$field4name,$field5name,$field6name,$field7name,$field8name,$field9name,$field10name,$field11name);
        echo "<h3>Employee records</h3>";
        echo "<table> 
                <thead>
                        <tr>
                            <th>EmpID</th>
                            <th>First Name</th>
                        </tr>
                    </thead>
            ";
    while ($stmt->fetch()) {
        printf('<tr>
            <td>%s</td>
            <td>%s</td>
        </tr>',
        $field1name, $field2name);

   }
   }
                echo '</table>';
                ?>
                