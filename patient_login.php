<?php
$conn = mysqli_connect("localhost", "root", "", "hospital") or die("connection failed");

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $query = "SELECT * FROM patients_signup WHERE phone='$phone'";
    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);
    echo $count;

    if ($count == 1) {
        while($row=mysqli_fetch_assoc($result)){
            if(password_verify($password, $row['password'])){
                header("Location: dashboard.php");
                exit;
            }
            else{
                $error_message = "Phone Number or Password is wrong";

            }
        }
    } else {
        $error_message = "Phone Number or Password is wrong";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="patient_signup.css">
</head>
<body>
    <div class="signup-container">
        <div class="left-section">
            <img src="pic/logo.png" alt="Your Logo">
        </div>
        <div class="right-section">
            <div class="signup-box">
                <form method="post" action="patient_login.php">
                    <h1>Login</h1>
                    <?php
                    if (isset($error_message)) {
                        echo "<p style='color: red;'>$error_message</p>";
                    }
                    ?>
                    <div class="input-container">
                        <input type="text" name="phone" placeholder="Phone Number" required>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" name="save">Log In</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
