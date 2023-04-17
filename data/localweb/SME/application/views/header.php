<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <style>
    #nav {
        font-family: Arial;
        font-size: 14px;
        width: 100%;
        float: left;
        /* position: fixed; */
        margin: 0 0 1em 0;
        padding: 0;
        list-style: none;
        /* background-color: rgb(7, 193, 193); */
    }

    #nav {
        list-style: none;
        border: 0;
    }

    #rightnav {
        list-style: none;
    }

    #nav li {
        float: left;
    }

    #rightnav li {
        float: right;
    }

    #nav li a {
        margin: 0 3px 0 0;
        font-size: 15px;
        display: block;
        padding: 8px 15px;
        text-decoration: none;
        color: #6e6d7a;
        transition: .4s;
        /* background-color: #fff; */
    }

    #nav li a i {
        margin: 0 5px;
    }

    #nav li a:hover {
        letter-spacing: 1.2px;
        color: #007FFF;
        fill: #007FFF;
        cursor: 'context-menu';
        /* background-color: #f2e4d5; */
    }

    #nav a:link,
    a:visited {
        border-radius: 12px 12px 12px 12px;
    }
    </style>
</head>

<script type="text/javascript" defer>
window.onload = function() {
    var navElement = document.getElementById("nav")
    var userType = localStorage.getItem("userType")
    console.log("🚀 ~ file: header.php:71 ~ userType:", userType)
    const box = `<li><a href='main/area'><i class="bi bi-geo"></i>Area</a></li>`;

    if (userType === "admin") {
        console.log('first')
        navElement.innerHTML = navElement.innerHTML + box;
    }
}
</script>

<body>
    <div>
        <ul id="nav">
            <li><a href='<?php echo site_url('') ?>'><i class="bi bi-house"></i>Home</a></li>

            <li><a href='<?php echo site_url('main/resident') ?>'><i class="bi bi-people"></i>Resident</a></li>
            <li><a href='<?php echo site_url('main/product') ?>'><i class="bi bi-lightbulb"></i>Product</a></li>
            <ul id="rightnav">
                <li><a href='<?php echo site_url('main/blank') ?>'>Sign out</a></li>
            </ul>
        </ul>
    </div>
</body>

</html>