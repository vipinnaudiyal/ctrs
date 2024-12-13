<?php

//-----------

$host="iitjdb.c34ko6kys3lo.us-east-1.rds.amazonaws.com";
$port=3306;
$socket="";
$user="admin";
$password="Admin123";
$dbname="mydb";

$con = new mysqli($host, $user, $password, $dbname, $port,$socket)
	or die ('Could not connect to the database server' . mysqli_connect_error());

//$con->close();

//===========

/*

$con = mysqli_connect("localhost", "root","","bdm_project"); #Connection string
if(mysqli_connect_errno())
{
    echo "Failed to connect:" . mysqli_connect_errno();
}
else{
    //echo "Connected";
}*/
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
                    <input type = "Submit" name = "training_programs"  class = "navigationButton" value = "Training Section" style = "width:170px;position: relative;top: 0px;right: 0px;background-color: whitesmoke;border-radius: 30px;height: 40px;">
                    </a>
                    <br>
                    <br>
                    <a href="employeedetails.php">
                    <input type = "Submit" name = "employee_details"  class = "navigationButton" value = "Employee Section" style = "width:170px;position: relative;top: 0px;right: 0px;background-color: whitesmoke;border-radius: 30px;height: 40px;">
                    </a> 
                    <br>
                    <br>
                    <a href = "trainingrecommender.php">
                    <input type = "Submit" name = "employee_recommender"  class = "navigationButton" value = "Recommendations" style = "width:170px;position: relative;top: 0px;right: 0px;background-color: whitesmoke;border-radius: 30px;height: 40px;">
                    </a> 
                </div> 
            </div>
        </div>
    </body>
                



