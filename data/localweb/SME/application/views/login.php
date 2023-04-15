<?php
session_start();
$_SESSION['data'] = "yourdata";
$message = "";
class foo
{public $name;}

if (isset($_POST['SubmitSmeSignupBtn'])) {
    $company_name = $_POST['company_name'];
    $phone_no = $_POST['phone_no'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = mysqli_connect('localhost', 'root', '', 'cw2');

    $qry1 = "INSERT INTO login (email, password, userType) VALUES (\"" . $email . '" , "' . $password . '", ' . '"sme");';
    if ($conn->query($qry1) === true) {
        $qry2 = "INSERT INTO sme (sme_id, company_name, phone_no, address, email, sme_status) VALUES (NULL, \"" . $company_name . '" , "' . $phone_no . '", "' . $address . '", "' . $email . '", ' . '"active");';

        if ($conn->query($qry2) === true) {
            echo '<script>alert("Successfully Registered");</script>';
        } else {
            echo "Error: " . $qry2 . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $qry1 . "<br>" . $conn->error;
    }
}

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
        header('Location: index.php/main/area');
    } else {
        printf("Invalid username or password : ");
    }
}

// echo "<script>console.log('Debug Objects: " . "data" . $result->fetch_array()[0] . "' );</script>";
?>



<html>

<body>
    <form id="smeSignupForm" action="" method="post">
        <?php echo $message; ?>

        <label for="company_name">Company Name:</label>
        <input type="text" id="company_name" name="company_name"><br>

        <label for="phone_no">Phone Number:</label>
        <input type="tel" id="phone_no" name="phone_no"><br>

        <label for="address">Address:</label>
        <textarea id="address" name="address"></textarea><br>

        <label for="email">Email:</label>
        <input id="email" name="email"><br>

        <label for="password">Password:</label>
        <input id="password" name="password"><br>

        <br>

        <input type="submit" name="SubmitSmeSignupBtn" />
    </form>
    <form id="loginForm" action="" method="post">
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
<script>
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
</script>