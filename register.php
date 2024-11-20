<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            echo "<script>
                    alert('Login Successful!');
                    window.location.href = 'dashboard.html';
                  </script>";
        } else {
            echo "<script>
                    alert('Invalid credentials! Password does not match.');
                    window.history.back();
                  </script>";
        }
    } else {
        echo "<script>
                alert('Invalid credentials! User not found.');
                window.history.back();
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
