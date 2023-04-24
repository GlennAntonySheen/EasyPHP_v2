<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <style>
    #nav {
        display: flex;
        justify-content: space-between;
        font-family: Arial;
        font-size: 14px;
        width: calc(100% - 0.5rem);
        float: left;
        border-radius: 1rem;
        /* position: fixed; */
        margin: 0 0 1em 0;
        padding: 0.3rem;
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        /* background-color: rgb(7, 193, 193); */
    }

    ul {
        padding: 0;
        list-style: none;
    }

    img {
        height: 50px;
    }

    #leftNav {
        margin-left: 1rem;
        background-color: red;
    }

    #leftNav,
    #rightNav {
        display: flex;
        align-items: center;
        /* background-color: yellow; */
    }

    #middleNav {
        display: flex;
        align-items: center;
        /* background-color: pink; */
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

    #nav li a:hover {
        letter-spacing: 1.2px;
        color: #FF6000;
        fill: #FF6000;
        cursor: 'context-menu';
        /* background-color: #f2e4d5; */
    }

    a:link,
    a:visited {
        border-radius: 12px 12px 12px 12px;
    }
    </style>
</head>

<script type="text/javascript" defer>
window.onload = function() {
    var middleNavElement = document.getElementById("middleNav")
    var rightNavElement = document.getElementById("rightNav")
    var userType = localStorage.getItem("userType")

    // No one is logged in
    if (userType === null) {
        middleNavElement.innerHTML = middleNavElement.innerHTML +
            `<li><a href='<?php echo site_url('') ?>'><i class="bi bi-house"></i>Home</a></li>`;
    } else {
        // Show sign out button if user is logged
        rightNavElement.innerHTML = rightNavElement.innerHTML + `<li><a href='<?php echo site_url('') ?>'><i class="bi bi-door-closed"></i>Sign out</a></li>`

        if (userType === "admin") {
            middleNavElement.innerHTML =  
            // `<li><a href='<?php echo site_url('main/localCouncil') ?>'><i class="bi bi-geo"></i>Local Council</a></li>` + 
            `<li><a href='<?php echo site_url('main/localCouncil') ?>'><i class="bi bi-buildings"></i>Local Council</a></li>`;
        } else if (userType === 'sme') {
            middleNavElement.innerHTML =  
            `<li><a href='<?php echo site_url('main/product') ?>'><i class="bi bi-geo"></i>Products</a></li>`;
        } else if (userType === 'localCouncil') {
            middleNavElement.innerHTML =  
            `<li><a href='<?php echo site_url('main/area') ?>'><i class="bi bi-geo"></i>Area</a></li>` +
            `<li><a href='<?php echo site_url('main/view_vote') ?>'><i class="bi bi-eyeglasses"></i>View Vote</a></li>`;
        } else if (userType === 'resident') {
            middleNavElement.innerHTML = 
            `<li><a href='<?php echo site_url('main/product') ?>'><i class="bi bi-bag-heart"></i>Vote Products</a></li>`;
        }
    }
}
</script>

<body>
    <div>
        <ul id="nav">
            <ul id="leftNav">
                <img src="https://res.cloudinary.com/dulilyahn/image/upload/v1682350335/logo_tergpo.png" alt="">
            </ul>
            <ul id="middleNav">
            </ul>
            <ul id="rightNav">
            <li><a href='<?php echo site_url('main/help') ?>'><i class="bi bi-journal-medical"></i>Help</a></li>
            <!-- <button onClick="console.log('dfg')">fdg</button> -->
            </ul>
        </ul>
    </div>
</body>

</html>