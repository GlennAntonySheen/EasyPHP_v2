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
        height: 91vh;
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
        padding: 1rem 2rem;
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

    form {}

    label {
        padding-left: .5rem;
    }

    input { 
        height: 30px;
        padding: 0 .5rem;
        border: 1.6px solid #EB7A14;
        border-radius: 1rem;
    }
    textarea {
        height: 60px;
        border: 1.6px solid #EB7A14;
        border-radius: 1rem;

    }

    input[type=submit] {
        width: 200px;
        padding: .4rem;
        color: #fff;
        background: #EB7A14;
        border:  none;
        cursor: pointer;
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
            <div class="signupForm">
                <form id="smeSignupForm" action="" method="post">
                    <?php echo $message; ?>
                    <div class="inputContainer">
                        <label for="company_name">Company Name:</label>
                        <input type="text" id="company_name" name="company_name">
                    </div>
                    <div class="inputContainer">
                        <label for="phone_no">Phone Number:</label>
                        <input type="tel" id="phone_no" name="phone_no">
                    </div>
                    <div class="inputContainer">
                        <label for="address">Address:</label>
                        <textarea id="address" name="address"></textarea>
                    </div>
                    <div class="inputContainer">
                        <label for="email">Email:</label>
                        <input id="email" name="email">
                    </div>
                    <div class="inputContainer">
                        <label for="password">Password:</label>
                        <input id="password" name="password">
                    </div>
                    <input type="submit" name="SubmitSmeSignupBtn" />
                </form>
            </div>
            <div class="loginForm">
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
                    <input type="submit" name="SubmitButton" />
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