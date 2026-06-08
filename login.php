<?php
session_start();
include 'db.php';

$message = "";

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    // ❗ INTENTIONALLY VULNERABLE (SQLi LAB)
    $query = "SELECT * FROM users 
              WHERE username='$username' 
              AND password='$password'";

    $result = mysqli_query($conn,$query);

    if($result && mysqli_num_rows($result) > 0){

        $user = mysqli_fetch_assoc($result);

        // session start safety
        session_regenerate_id(true);

        $_SESSION['user'] = $user['username'];
        $_SESSION['name'] = $user['full_name'];
        $_SESSION['balance'] = $user['balance'];
        $_SESSION['account'] = $user['account_no'];
        $_SESSION['id'] = $user['id'];

        // ✅ simple role flag (important fix)
        $_SESSION['role'] = $user['username'];

        // ADMIN REDIRECT
        if($user['username'] === 'admin'){
            header("Location: admin.php");
            exit();
        }

        // USER REDIRECT
        header("Location: dashboard.php");
        exit();

    } else {
        $message = "Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - MiniBank</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <div class="card">

        <h2>Customer Login</h2>
        <p class="subtle">Sign in to view your banking dashboard and account information.</p>

        <form method="POST">

            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit" name="login">Login</button>

        </form>

        <p class="error"><?php echo $message; ?></p>

        <a href="index.php">Back Home</a>

    </div>

</div>

</body>
</html>
