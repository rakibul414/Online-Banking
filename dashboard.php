<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - MiniBank</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard-page">

<div class="dashboard-shell">
    <div class="topbar">
        <div class="brand">
            <strong>MiniBank Dashboard</strong>
            <span>Welcome back, <?php echo $_SESSION['user']; ?></span>
        </div>

        <a class="logout-link" href="logout.php">Logout</a>
    </div>

    <div class="panel">
        <div class="meta-row">
            <span class="pill">Signed in as <?php echo $_SESSION['user']; ?></span>
            <span class="pill">Account overview</span>
        </div>

        <h2 class="section-title">Welcome <?php echo $_SESSION['user']; ?></h2>
        <p class="section-subtitle">Your account details are shown below in a clean, responsive layout.</p>

        <div class="grid two-up">
            <div class="info-box">
                <div class="stat-label">User</div>
                <div class="stat-value"><?php echo $_SESSION['user']; ?></div>
            </div>

            <div class="info-box">
                <div class="stat-label">User ID</div>
                <div class="stat-value"><?php echo $_SESSION['id']; ?></div>
            </div>
        </div>

        <div class="section">
            <h3>Account Lookup</h3>
            <p class="subtle">Search by account number to display matching account details.</p>

            <form method="GET">
                <input type="text" name="acc" placeholder="Enter Account No">
                <input type="submit" value="Search">
            </form>

            <div class="results">
<?php

if(isset($_GET['acc'])){

    $acc = $_GET['acc'];

    // ❗ intentionally vulnerable for lab
    $query = "SELECT * FROM users WHERE account_no='$acc'";

    $result = mysqli_query($conn, $query);

    if($result){

        while($row = mysqli_fetch_assoc($result)){

            echo '<div class="result-card">';
            echo "<b>Account No:</b> " . $row['account_no'] . "<br>";
            echo "<b>Name:</b> " . $row['full_name'] . "<br>";
            echo "<b>Balance:</b> " . $row['balance'] . "<br>";
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

</body>
</html>
