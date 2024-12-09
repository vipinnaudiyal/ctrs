<form action="" method="POST">

    <select id="selectype" name="cards">
        <option value="WorkOrder">Work Order</option>
        <option value="FirstName">First Name</option>
    </select>

    <input type="submit" />

</form>

<?php

    $cards = $_POST['cards'];

    if ($cards == "WorkOrder")
       echo "WorkOrder selected";

    else if ($cards == "FirstName")
       echo "FirstName selected";

    else
       echo "Doesn't work";
?>