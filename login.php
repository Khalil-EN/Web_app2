<?php
// Database configuration
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'narsa_login';

// Create a connection to the MySQL database
$conn = new mysqli($hostname, $username, $password, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['signIn'])){
    $rfidtag = $_POST['rfidtag'];
    $password = $_POST['password'];

    // Use prepared statement to prevent SQL injection
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $rfidtag);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $resultPassword = $row['password'];

        if($password == $resultPassword){
            header('Location: accueil.html');
            exit();
        } else {
            echo "<script>alert('Login unsuccessful');</script>";
        }
    } else {
        echo "<script>alert('User not found');</script>";
    }
}

$conn->close();
?>
