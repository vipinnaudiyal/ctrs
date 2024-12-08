<?php
$con = mysqli_connect("localhost", "root","","bdm_project"); #Connection string
if(mysqli_connect_errno())
{
    echo "Failed to connect:" . mysqli_connect_errno();
}
else{
    echo "Connected to the DB in Local Machine";
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
                    <h3>IIT JODHPUR, Cloud Computing</h>
                </div>
                <div id = "first">
                    <!--Creating login form--> 
                    <form method = "POST">
                        <input type ="text" name = "fname" placeholder = "First Name" value = "">
                        <input type ="text" name = "lname" placeholder = "Last Name" value = "">
                        <input type ="text" name = "address" placeholder = "Address" value = "">
                        <input type ="text" name = "contact" placeholder = "Contact" value = "">
                        <input type ="text" name = "city" placeholder = "City" value = "">
                        <input type ="text" name = "hobby" placeholder = "Hobbies" value = "">
                        <div style = "width:100%">
                        <br>
                        <input type = "submit" name = "button" value = "Insert Data">
                        <br>
                        <br>
                        <br>
                        <input type = "submit" name = "bulk" value = "Insert Bulk">
                        <br>
                        <hr>
                        <input type = "submit" name = "show" value = "Show Records">
                        <br>
                        <br>
                        <input type = "submit" name = "clean" value = "Clean DB">
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

<?php
        if(array_key_exists('bulk', $_POST)) { 
            bulk(200000); 
        } 
        function bulk($count_record) {  
            echo "The DB update start time is " . date("h:i:sa");
            for ($x = 0; $x <= $count_record; $x++) {
                $fname = generateRandomString(50);
                $lname = generateRandomString(50);
                $hobby = generateRandomString(100);
                $address = generateRandomString(100);
                $contact = generateRandomNumber(10);
                $city = generateRandomString(50);
                $con = mysqli_connect("localhost", "root","","social_2"); #Connection string
                $query = mysqli_query($con,"INSERT INTO myTable VALUES(NULL,'$fname','$lname','$hobby','$address','$contact','$city')");
              } 
            echo "<br>" ;
            echo "Database updated successfully for " .$count_record." records and end time is " . date("h:i:sa") ;
            echo "<br>";
            }
        if(array_key_exists('button', $_POST)) { 
            button1(); 
        } 
        function button1() { 
            $fname = strip_tags($_POST['fname']);
            $lname = strip_tags($_POST['lname']);
            $hobby = strip_tags($_POST['hobby']);
            $address = strip_tags($_POST['address']);
            $contact = strip_tags($_POST['contact']);
            $city = strip_tags($_POST['city']);
            $con = mysqli_connect("localhost", "root","","social_2"); #Connection string
            $query = mysqli_query($con,"INSERT INTO myTable VALUES(NULL,'$fname','$lname','$hobby','$address','$contact','$city')");  
            echo "Database updated successfully" ;  
            }  
        if(array_key_exists('show', $_POST)) { 
            button2(); 
        }
        function button2() { 
            echo "<br><tr> The DB view start time is " . date("h:i:sa")."<br>";
            $con = mysqli_connect("localhost", "root","","social_2"); #Connection string
            if(mysqli_connect_errno())
            {
                echo "Failed to connect:" . mysqli_connect_errno();
            }
            $result = mysqli_query($con,"SELECT * FROM myTable");
            echo "DATABASE TABLE<br><br>";
            echo '<table border="0" cellspacing="2" cellpadding="2"> 
                <tr>     
                </tr>';
                while ($row = $result->fetch_assoc()) {
                    $field1name = $row["id"];
                    $field2name = $row["first_name"];
                    $field3name = $row["last_name"];
                    $field4name = $row["hobby"];
                    $field5name = $row["address"];
                    $field6name = $row["city"];
                    $field7name = $row["contact"];        
                    echo ' 
                            <td>'.$field1name.'</td>
                            <td>'.$field2name.'</td> 
                            <td>'.$field3name.'</td> 
                            <td>'.$field4name.'</td>
                            <td>'.$field5name.'</td> 
                            <td>'.$field6name.'</td> 
                            <td>'.$field7name.'</td> 
                        ';
                } 
            echo "<br> The DB view stop time is " . date("h:i:sa");
            }
            
        function generateRandomString($length = 10) {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
            
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[random_int(0, $charactersLength - 1)];
                }
            
                return $randomString;
            }
        function generateRandomNumber($length = 10) {
            $characters = '0123456789';
            $charactersLength = strlen($characters);
            $randomString = '';
        
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[random_int(0, $charactersLength - 1)];
            }
        
            return $randomString;
        }
        if(array_key_exists('clean', $_POST)) { 
            button4(); 
        } 
        function button4() {  
            {
                {
                $con = mysqli_connect("localhost", "root","","social_2"); #Connection string
                $query = mysqli_query($con,"DELETE FROM myTable");  
                }  
            }
            echo "Database deleted successfully" ;            
        }
    ?> 



