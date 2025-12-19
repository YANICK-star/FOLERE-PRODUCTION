<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "folere_orders");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_POST['customer_name'], $_POST['phone_number'], $_POST['order_details'])) {
        die("Form fields missing!");
    }

    $name  = trim($_POST['customer_name']);
    $phone = trim($_POST['phone_number']);
    $order = trim($_POST['order_details']);

    $stmt = $conn->prepare(
        "INSERT INTO orders (customer_name, phone_number, order_details)
         VALUES (?, ?, ?)"
    );

    $stmt->bind_param("sss", $name, $phone, $order);

    if ($stmt->execute()) {
        echo "✅ Order saved successfully!";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
