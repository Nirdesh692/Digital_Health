<?php
// Database connection
$host = "localhost"; // Change this to your database server hostname or IP address
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$database = "hospital";

try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST["full_name"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query to insert user data into the database
    $query = "INSERT INTO patients_signup (full_name, address, phone, password) VALUES (:full_name, :address, :phone, :password)";
    
    try {
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":full_name", $full_name);
        $stmt->bindParam(":address", $address);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":password", $hashed_password); // Store the hashed password

        $stmt->execute();

        // Redirect to a success page or login page
        header("Location: patient_login.php");
        exit;
    } catch (PDOException $e) {
        // Handle duplicate phone numbers or other errors
        echo "Error: " . $e->getMessage();
    }
}
?>