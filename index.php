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

    $query = 'CREATE TABLE employee( '.
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
    echo "Table employee created successfully\n";

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
</style>
    <title>Document</title>
</head>
<body>
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

</body>
</html>


