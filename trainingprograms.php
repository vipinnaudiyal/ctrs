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
            $con = mysqli_connect("localhost", "root","","bdm_project"); #Connection string
            if(mysqli_connect_errno())
            {
                echo "Failed to connect:" . mysqli_connect_errno();
            }
            $result = mysqli_query($con,"SELECT * FROM training_and_development_data");
            echo "<h3>Training records</h3>";
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
                while ($row = $result->fetch_assoc()) {
                    $field1name = $row["Employee ID"];
                    $field2name = $row["Training Date"];
                    $field3name = $row["Training Program Name"];
                    $field4name = $row["Training Type"];
                    $field5name = $row["Training Outcome"];
                    $field6name = $row["Location"];
                    $field7name = $row["Trainer"]; 
                    $field8name = $row["Training Duration(Days)"];
                    $field9name = $row["Training Cost"];        
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
                $result = mysqli_query($con,'SELECT DISTINCT(`Training Program Name`),`Training Cost`,`Training Duration(Days)`,`Trainer`,`Location` FROM `training_and_development_data` GROUP BY `Training Program Name`;');
                //$result = mysqli_query($con,"SELECT * FROM training_and_development_data");
                
                echo "<h3>List of trainings</h3>";
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
                    while ($row = $result->fetch_assoc()) {
                        $field3name = $row["Training Program Name"];
                        $field6name = $row["Location"];
                        $field7name = $row["Trainer"]; 
                        $field8name = $row["Training Duration(Days)"];
                        $field9name = $row["Training Cost"];        
                        echo ' <tr>
                                <td>'.$field3name.'</td> 
                                <td>'.$field6name.'</td> 
                                <td>'.$field7name.'</td> 
                                <td>'.$field8name.'</td> 
                                <td>'.$field9name.'</td>
                                </tr>
                            ';
                    } 
                    echo '</table>';
                }
    ?> 



