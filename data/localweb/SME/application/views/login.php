<?php
session_start(); 
$_SESSION['data'] = "yourdata";
$message = "";
class foo
{public $name;}

if (isset($_POST['SubmitButton'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $message = "SELECT * FROM login WHERE email = " . '"' . $username . '"' . " AND password = " . '"' . $password . '";';
    
    $conn = mysqli_connect('localhost', 'root', '', 'cw2');
    $query = "SELECT * FROM login WHERE email = " . '"' . $username . '"' . " AND password = " . '"' . $password . '";';
    $result = mysql_query($query);
    $obj = mysql_fetch_object($result, 'foo');
    if ($obj) {
        echo '<script> sessionStorage.setItem("userType", "' . $obj->userType . '");</script>';
        var_dump($obj->userType);
        // header('Location: index.php/main/area');
    } else {
        printf("Invalid username or password : ");
    }

    // echo "<script>console.log('Debug Objects: " . "data" . $result->fetch_array()[0] . "' );</script>";
}

?>



<html>

<body>
    <form action="" method="post">
        <?php echo $message; ?>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <input type="submit" name="SubmitButton" />
    </form>
</body>

</html>