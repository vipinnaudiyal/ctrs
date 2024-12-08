<?php
$con = mysqli_connect("localhost", "root","","bdm_project"); #Connection string
if(mysqli_connect_errno())
{
    echo "Failed to connect:" . mysqli_connect_errno();
}
else{
    //echo "Connected";
}
?>
<!DOCTYPE html>
   <head>
    <title>IIT</title>
    </head>
    <body>
        <div class = "wrapper">
            <div class = "login_box">
                <div class = 'login_header'>
                    <h1 style = "text-align: center;  font-family: Arial, sans-serif;">Welcome to IIT Jodhpur</h1>
                    <h3 style = "text-align: center;  font-family: Arial, sans-serif;">Corporate Training Recommender System</h3>
                </div>
                <div>
                    <h4 style = "font-family: Arial, sans-serif;">Navigations >></h4>
                    <a href="trainingprograms.php">
                    <input type = "Submit" name = "training_programs"  class = "navigationButton" value = "Training Programs" style = "width:150px;position: relative;top: 0px;right: 0px;background-color: whitesmoke;border-radius: 9px;">
                    </a>
                    <br>
                    <br>
                    <a href="employeedetails.php">
                    <input type = "Submit" name = "employee_details"  class = "navigationButton" value = "Employee Details" style = "width:150px;position: relative;top: 0px;right: 0px;background-color: whitesmoke;border-radius: 9px;">
                    </a> 
                    <br>
                    <br>
                    <a>
                    <input type = "Submit" name = "employee_recommender"  class = "navigationButton" value = "Employee Recommender" style = "width:150px;position: relative;top: 0px;right: 0px;background-color: whitesmoke;border-radius: 9px;">
                    </a> 
                </div> 
            </div>
        </div>
    </body>
                



