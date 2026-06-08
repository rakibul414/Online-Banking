<?php
session_start();
include 'db.php';

// 🔐 proper access control
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

if($_SESSION['user'] !== 'admin'){
    die("Access Denied!");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - MiniBank SQLi Lab</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard-page">

<div class="dashboard-shell">
    <div class="topbar">
        <div class="brand">
            <strong>Admin Panel</strong>
            <span>MiniBank SQLi Lab</span>
        </div>

        <a class="logout-link" href="dashboard.php">Back</a>
    </div>

    <div class="panel">
        <div class="meta-row">
            <span class="pill">Administrative tools</span>
            <span class="pill">Record lookup</span>
        </div>

        <h2 class="section-title">🏦 Admin Panel</h2>
        <p class="section-subtitle">Use the search tools below to look up user records.</p>

        <div class="grid two-up">
            <div class="info-box">
                <h3>Search by Username</h3>

                <form method="GET">
                    <input type="text" name="username" placeholder="Enter username">
                    <input type="submit" value="Search">
                </form>

                <div class="results">
<?php

if(isset($_GET['username'])){

    $username = $_GET['username'];

    // ❗ SQLi vulnerable
    $query = "SELECT * FROM users WHERE username='$username'";

    $result = mysqli_query($conn, $query);

    if($result){

        while($row = mysqli_fetch_assoc($result)){

            echo '<div class="result-card">';
            echo "ID: ".$row['id']."<br>";
            echo "Username: ".$row['username']."<br>";
            echo "Name: ".$row['full_name']."<br>";
            echo "Account: ".$row['account_no']."<br>";
            echo "Balance: ".$row['balance'];
            echo '</div>';
        }

    } else {
        echo '<div class="result-card">Query Error: ' . mysqli_error($conn) . '</div>';
    }
}
?>
                </div>
            </div>

            <div class="info-box">
                <h3>Search by ID</h3>

                <form method="GET">
                    <input type="text" name="id" placeholder="Enter ID">
                    <input type="submit" value="Search">
                </form>

                <div class="results">
<?php

if(isset($_GET['id'])){

    $id = $_GET['id'];

    // ❗ SQLi vulnerable
    $query = "SELECT * FROM users WHERE id=$id";

    $result = mysqli_query($conn, $query);

    if($result){

        while($row = mysqli_fetch_assoc($result)){

            echo '<div class="result-card">';
            echo "ID: ".$row['id']."<br>";
            echo "Username: ".$row['username']."<br>";
            echo "Name: ".$row['full_name']."<br>";
            echo "Account: ".$row['account_no']."<br>";
            echo "Balance: ".$row['balance'];
            echo '</div>';
        }

    } else {
        echo '<div class="result-card">Query Error: ' . mysqli_error($conn) . '</div>';
    }
}
?>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
