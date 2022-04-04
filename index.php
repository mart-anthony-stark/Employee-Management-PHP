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
    if(isset($_POST['submit'])) {
        $emp_name = $_POST['emp_name'];
        $emp_address = $_POST['emp_address'];
        $emp_salary = $_POST['emp_salary'];
        $join_date = $_POST['join_date'];

        $query = "INSERT INTO employee (emp_name, emp_address, emp_salary, join_date) VALUES ('$emp_name', '$emp_address', '$emp_salary', '$join_date')";
        $retval = $conn -> query( $query );
        if(!$retval ) {
            die('Could not enter data: ' . mysql_error());
        }
        echo "Entered data successfully\n";
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- style table -->
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even){background-color: #f2f2f2}

    th {
        background-color: #4CAF50;
        color: white;
    }
    form {
        border: 3px solid #f1f1f1;
    }

    input[type=text], input[type=date] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    button {
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
    }

    button:hover {
        opacity: 0.8;
    }

    .cancelbtn {
        width: auto;
        padding: 10px 18px;
        background-color: #f44336;
    }

    .imgcontainer {
        text-align: center;
        margin: 24px 0 12px 0;
    }

    img.avatar {
        width: 40%;
        border-radius: 50%;
    }

    .container {
        padding: 16px;
    }

    span.psw {
        float: right;
        padding-top: 16px;
    }

    /* Change styles for span and cancel button on extra small screens */
    @media screen and (max-width: 300px) {
        span.psw {
            display: block;
            float: none;
        }
        .cancelbtn {
            width: 100%;
        }
    }
    /* style add employee button */
    .addbtn {
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
    }
</style>
    <title>Document</title>
</head>
<body>
    <!-- create form for adding employee to database -->
    <form class="add" action="index.php" method="post">
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
                <td><input class="addbtn" type="submit" name="submit" value="Add Employee"></td>
            </tr>
        </table>
    </form>
    <!-- create employee table  (id, name address, salary, join date)-->
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
                    echo '<tr>';
                    echo '<td>'.$row['emp_id'].'</td>';
                    echo '<td>'.$row['emp_name'].'</td>';
                    echo '<td>'.$row['emp_address'].'</td>';
                    echo '<td>'.$row['emp_salary'].'</td>';
                    echo '<td>'.$row['join_date'].'</td>';
                    echo '</tr>';
                }
            }
        ?>
    </tbody>
</table>
<!-- handle edit employee -->
<?php
    if(isset($_POST['edit'])) {
        $emp_id = $_POST['emp_id'];
        $query = "SELECT * FROM employee WHERE emp_id = '$emp_id'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $emp_name = $row['emp_name'];
                $emp_address = $row['emp_address'];
                $emp_salary = $row['emp_salary'];
                $join_date = $row['join_date'];
            }
        }
    }
?>
<!-- create form for editing employee -->
<form class="edit" action="index.php" method="post">
    <table>
        <tr>
            <td>Employee ID:</td>
            <td><input type="text" name="emp_id" value="<?php echo $emp_id; ?>" required></td>
        </tr>
        <tr>
            <td>Employee Name:</td>
            <td><input type="text" name="emp_name" value="<?php echo $emp_name; ?>" required></td>
        </tr>
        <tr>
            <td>Employee Address:</td>
            <td><input type="text" name="emp_address" value="<?php echo $emp_address; ?>" required></td>
        </tr>
        <tr>
            <td>Employee Salary:</td>
            <td><input type="number" name="emp_salary" value="<?php echo $emp_salary; ?>" required></td>
        </tr>
        <tr>
            <td>Employee Join Date:</td>
            <td><input type="date" name="join_date" value="<?php echo $join_date; ?>" required></td>
        </tr>
        <tr>
            <td></td>
            <td><input class="addbtn" type="submit" name="update" value="Update Employee"></td>
        </tr>
    </table>
</form>
</body>
</html>


<!-- style insert employee form -->
<style>
    
</style>