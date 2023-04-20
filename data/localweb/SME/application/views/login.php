<?php
session_start();
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

if (isset($_POST['SubmitResidentSignupBtn'])) {
    $area_id = $_POST['area'];
    $title = $_POST['title'];
    $name = $_POST['name'];
    $phone_no = $_POST['phone_no'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $age = $_POST['age'];
    
    $conn = mysqli_connect('localhost', 'root', '', 'cw2');    
    

    $qry1 = "INSERT INTO login (email, password, userType) VALUES (\"" . $email . '" , "' . $password . '", ' . '"resident");';
    if ($conn->query($qry1) === true) {
        $qry2 = 'INSERT INTO resident (resident_id, area_id, tittle, resident_name, phone_no, email, age, resident_status) VALUES (NULL, ' . $area_id . ' , "' . $title . '", "' . $name . '" , "' . $phone_no . '" , "' . $email . '", ' . $age . ', "active");';

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
        echo '<script>localStorage.setItem("userType", "' . $obj->userType . '");</script>';
        if ($obj->userType == 'admin') {
            echo '<script>window.location.replace("index.php/main/area");</script>';
        } elseif ($obj->userType == 'sme') {
            echo '<script>window.location.replace("index.php/main/product");</script>';
        } elseif ($obj->userType == 'resident') {
            echo '<script>window.location.replace("index.php/main/resident");</script>';
        }
    } else {
        printf("Invalid username or password : ");
    }
}

?>



<html>

<head>
    <style>
    body {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .contentWrapper {
        height: 89vh;
        display: flex;
        gap: 2rem;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    }

    .introSection {
        width: 300px;
        flex: 1;
        border-radius: 1rem;
        overflow: hidden;

    }

    .coverImg {
        height: 91vh;
        width: 100%;
        /* max-width: 300px;  */
        /* height: auto; */
    }


    .formContainer {
        max-width: 500px;
        padding: 1rem 3rem;
        display: flex;
        flex-direction: column;
        gap: 3rem;
        flex: 1;
        overflow: auto;
        /* background-color: blue; */
    }

    .signupForm,
    .loginForm {
        /* height: 200px; */
        /* flex-grow: 1; */
        padding: 1rem;
        /* border: 2px solid #f00; */
        /* background-color: yellow; */

    }

    .inputContainer {
        width: 100%;
        display: flex;
        flex-direction: column;
        font-family: Arial;
        color: #6e6d7a;

        /* background-color: red; */
    }

    h2 {
        padding-left: .5rem;
        font-family: Arial;
        color: #333c33;
    }

    label {
        padding-left: .5rem;
    }

    input,
    select {
        height: 30px;
        padding: 0 .5rem;
        border: 1.6px solid #FF6000;
        border-radius: 1rem;
    }

    textarea {
        height: 60px;
        padding: 0 .5rem;
        border: 1.6px solid #FF6000;
        border-radius: 1rem;

    }

    input[type=submit] {
        width: 200px;
        padding: .4rem;
        color: #fff;
        background: #FF6000;
        border: none;
        cursor: pointer;
        font-size: 15px;
        -webkit-border-radius: 1rem;
        border-radius: 1rem;
    }

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        /* border: 2px solid #f00; */
        /* background-color: green; */
    }
    </style>
</head>

<body>
    <div class="contentWrapper">

        <div class="introSection">
            <img class="coverImg" src="assets/images/19018.jpg" alt="">
        </div>
        <div class="formContainer">
            <div class="loginForm">
                <h2>Login</h2>
                <form id="loginForm" action="" method="post">
                    <?php echo $message; ?>
                    <div class="inputContainer">
                        <label for="username">Username:</label>
                        <input type="text" name="username" id="username" required>
                    </div>
                    <div class="inputContainer">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" required>
                    </div>
                    <input type="submit" name="SubmitButton" value="Login" />
                </form>
            </div>
            <div class="signupForm">
                <h2>Register as a Resident</h2>
                <form id="residentSignupForm" action="" method="post">
                    <div class="inputContainer">
                        <label for="area">Area*:</label>
                        <select name="area" id="area" >
                            <option value="">Please select one</option>
                            <?php
$sql = "SELECT * FROM area;";

$conn = mysqli_connect('localhost', 'root', '', 'cw2');
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<option value="' . $row['area_id'] . '">' . $row['postcode'] . '</option>'; //assuming your table has columns "id" and "name"
    }
}
?>
                        </select>
                    </div>
                    <div class="inputContainer">
                        <label for="Title">Title*:</label>
                        <select name="title" id="title" >
                            <option value="">Please select one</option>
                            <option value="Mr">Mr</option>;
                            <option value="Ms">Ms</option>;
                            <option value="Other">Other</option>;
                        </select>
                    </div>
                    <div class="inputContainer">
                        <label for="name">Name*:</label>
                        <input type="text" name="name" id="name" >
                    </div>
                    <div class="inputContainer">
                        <label for="phone_no">Phone Number*:</label>
                        <input type="tel" id="phone_no" name="phone_no">
                    </div>
                    <div class="inputContainer">
                        <label for="age">Age*:</label>
                        <input type="number" name="age" id="age" >
                    </div>
                    <div class="inputContainer">
                        <label for="email">Email*:</label>
                        <input id="email" name="email">
                    </div>
                    <div class="inputContainer">
                        <label for="password">Password*:</label>
                        <input id="password" name="password">
                    </div>
                    <input type="submit" name="SubmitResidentSignupBtn" value="Submit">
                </form>
            </div>
            <div class="signupForm">
                <h2>Register as a SME</h2>
                <form id="smeSignupForm" action="" method="post">
                    <?php echo $message; ?>
                    <div class="inputContainer">
                        <label for="company_name">Company Name*:</label>
                        <input type="text" id="company_name" name="company_name">
                    </div>
                    <div class="inputContainer">
                        <label for="phone_no">Phone Number*:</label>
                        <input type="tel" id="phone_no" name="phone_no">
                    </div>
                    <div class="inputContainer">
                        <label for="address">Address*:</label>
                        <textarea id="address" name="address"></textarea>
                    </div>
                    <div class="inputContainer">
                        <label for="email">Email*:</label>
                        <input id="email" name="email">
                    </div>
                    <div class="inputContainer">
                        <label for="password">Password*:</label>
                        <input id="password" name="password">
                    </div>
                    <input type="submit" name="SubmitSmeSignupBtn" value="Register as SME" />
                </form>
            </div>
        </div>
    </div>
</body>

</html>
<script>
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
</script>