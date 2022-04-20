<!--
BSIT-2C
    Salazar, Mart Anthony
    Pardo, Precious
    Escota, Sherry Mae
-->
<?php
    // Enable error reporting for mysqli
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
    
    // Set the desired charset after establishing a connection
    $conn->set_charset('utf8mb4');

    // Create database if not exists.
    $databaseName = 'test_db';
    $query = 'CREATE DATABASE IF NOT EXISTS ' . $databaseName;

    $conn->query($query);

    // Use the new database for all future SQL queries.
    mysqli_select_db($conn, $databaseName);

    $query = 'CREATE TABLE IF NOT EXISTS employee( '.
    'emp_id INT NOT NULL AUTO_INCREMENT, '.
    'emp_name VARCHAR(20) NOT NULL, '.
    'emp_address VARCHAR(20) NOT NULL, '.
    'emp_salary INT NOT NULL, '.
    'join_date timestamp(6) NOT NULL, '.
    'primary key ( emp_id ))';

    $retval = $conn -> query( $query );
    if(!$retval ) {
        die('Could not create table: ' . mysql_error());
    }

    // handle post method for inserting employee record
    if(isset($_POST['addEmployee'])) {
        $emp_name = $_POST['emp_name'];
        $emp_address = $_POST['emp_address'];
        $emp_salary = $_POST['emp_salary'];
        $join_date = $_POST['join_date'];

        $query = "INSERT INTO employee (emp_name, emp_address, emp_salary, join_date) VALUES ('$emp_name', '$emp_address', '$emp_salary', '$join_date')";
        $retval = $conn -> query( $query );
        if(!$retval ) {
            die('Could not enter data: ' . mysql_error());
        }
    }
    
    if(isset($_POST['editEmployee'])) {
        $emp_id = $_POST['id'];
        $query = "UPDATE employee SET emp_name='$_POST[name]', emp_address='$_POST[address]', emp_salary='$_POST[salary]', join_date='$_POST[join_date]' WHERE emp_id = '$emp_id'";
        $conn -> query( $query );
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- style table -->
    <link rel="stylesheet" href="./styles.css">
    <title>Employee</title>
</head>
<body>
    <div class="buttons">
        <button class="add-emp-btn">ADD EMPLOYEE</button>
    </div>
    <!-- create form for adding employee to database -->
    <div class="add-overlay overlay hidden"></div>
    <form class="add hidden" action="index.php" method="post">

        <table>
            <tr>
                <td>Employee Name:</td>
                <td><input type="text" name="emp_name" required></td>
            </tr>
            <tr>
                <td>Employee Address:</td>
                <td><input type="text" name="emp_address" required></td>
            </tr>
            <tr>
                <td>Employee Salary:</td>
                <td><input type="number" name="emp_salary" required></td>
            </tr>
            <tr>
                <td>Employee Join Date:</td>
                <td><input type="date" name="join_date" required></td>
            </tr>
            <tr>
                <td></td>
                <td><input class="btn addbtn" type="submit" name="addEmployee" value="Add Employee"></td>
                <td><button class="btn" type="button">Cancel</button></td>
            </tr>
        </table>
    </form>
    <!-- create employee table  (id, name address, salary, join date)-->
    <!-- EDIT FORM -->
    <div class="edit-overlay overlay hidden"></div>
    <form class="edit hidden" action="index.php" method="post">
        
        <input type="text" readonly name="id">
        <table>
            <tr>
                <td>Employee Name:</td>
                <td><input class="input" type="text" name="name" required></td>
            </tr>
            <tr>
                <td>Employee Address:</td>
                <td><input class="input" type="text" name="address" required></td>
            </tr>
            <tr>
                <td>Employee Salary:</td>
                <td><input class="input" type="number" name="salary" required></td>
            </tr>
            <tr>
                <td>Employee Join Date:</td>
                <td><input class="input" type="date" name="join_date" required></td>
            </tr>
            <tr>
                <td></td>
                <td><input class="btn addBtn" type="submit" name="editEmployee" value="Save"></td>
                <td><button type="button" onClick="hide('edit')" class="cancelEditBtn">Cancel</button></td>
            </tr>
        </table>
    </form>
<table>
    <thead>
        <th>
            Employee ID
        </th>
        <th>
            Employee Name
        </th>
        <th>
            Employee Address
        </th>
        <th>
            Employee Salary
        </th>
        <th>
            Join Date
        </th>
    </thead>
    <tbody>
        <?php
            $query = 'SELECT * FROM employee';
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<tr id="row-'.$row['emp_id'].'">';
                    echo '<td>'.$row['emp_id'].'</td>';
                    echo '<td>'.$row['emp_name'].'</td>';
                    echo '<td>'.$row['emp_address'].'</td>';
                    echo '<td>'.$row['emp_salary'].'</td>';
                    echo '<td>'.$row['join_date'].'</td>';
                    echo '<td><button onclick="edit('.$row['emp_id'].')">EDIT</button></td>';
                    echo '</tr>';
                }
            }
        ?>
    </tbody>
</table>
</body>
    <script src="./app.js"></script>
</html>


<!-- style insert employee form -->
<style>
    
</style>