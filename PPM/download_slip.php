<?php
echo $_POST['employee_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown:hover .dropdown-content {
  display: block;
}
</style>
</head>
<body>
<table>
    <tr>
        <th>Employee Name</th>
        <td>John Doe</td>
    </tr>
    <tr>
        <th>Salary</th>
        <td>$3000</td>
    </tr>
</table>
<button class='dropdown' onclick="fetchSalarySlip()">View Salary Slip</button>
<div id="salary-slip-div" class='dropdown-content'></div>
</body>
</html>

