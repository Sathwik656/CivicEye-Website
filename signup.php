<?php
$servername = "localhost"; // Change this if your DB is on a remote server
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "civic_eye"; // Your database name

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Generate a unique Citizen Code (CTZ-XXXXXX)
function generateCitizenCode() {
    return "CTZ-" . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
}

// Fetch form data
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$address = $_POST['address'];
$city = $_POST['city'];
$pincode = $_POST['pincode'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encrypt password
$citizen_code = generateCitizenCode(); // Generate Citizen Code

// SQL query to insert user into database
$sql = "INSERT INTO users (citizen_code, name, phone, email, address, city, pincode, password) 
        VALUES ('$citizen_code', '$name', '$phone', '$email', '$address', '$city', '$pincode', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "<h2 style='color: green; text-align: center;'>Signup successful! Your Citizen Code: <strong>$citizen_code</strong></h2>";
} else {
    echo "<h2 style='color: red; text-align: center;'>Error: " . $sql . "<br>" . $conn->error . "</h2>";
}

$conn->close();

?>