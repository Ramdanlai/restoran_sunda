<?php
// Database connection
$host = 'localhost';
$dbname = 'restaurant_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Start session
session_start();

// If cart is empty, redirect back to menu
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
    header("Location: index.php");
    exit();
}

// Handle customer information submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_order'])) {
    $name = $_POST['customer_name'];
    $phone = $_POST['customer_phone'];
    $email = $_POST['customer_email'];

    // Collect order details
    $orderDetails = json_encode($_SESSION['cart']);

    // Save the order to the database
    $stmt = $pdo->prepare("INSERT INTO customer_orders (name, phone, email, order_details) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $phone, $email, $orderDetails]);

    // Save order information in session for payment processing
    $orderDetails = json_encode($_SESSION['cart']); // Simpan detail order dalam format JSON
    $_SESSION['order'] = [
        'customer_name' => $_POST['customer_name'],
        'customer_phone' => $_POST['customer_phone'],
        'customer_email' => $_POST['customer_email'],
        'order_details' => $orderDetails,
    ];
    

    // Redirect to payment page after saving order
header("Location: payment.php");
exit();

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .form-icon {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #6c757d;
        }
        .form-control {
            padding-left: 2.5rem;
        }
        .btn-success {
            background-color: #28a745;
            border: none;
        }
        .btn-success:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card p-4">
                    <h2 class="text-center mb-4">Informasi Pelanggan</h2>
                    <form method="POST">
                        <!-- Nama -->
                        <div class="mb-3 position-relative">
                            <label for="customer_name" class="form-label">Nama</label>
                            <i class="bi bi-person-fill form-icon"></i>
                            <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Masukkan nama Anda" required>
                        </div>
                        <!-- No Telpon -->
                        <div class="mb-3 position-relative">
                            <label for="customer_phone" class="form-label">No Telpon</label>
                            <i class="bi bi-telephone-fill form-icon"></i>
                            <input type="text" name="customer_phone" id="customer_phone" class="form-control" placeholder="Masukkan nomor telepon" required>
                        </div>
                        <!-- Email -->
                        <div class="mb-3 position-relative">
                            <label for="customer_email" class="form-label">Alamat Email</label>
                            <i class="bi bi-envelope-fill form-icon"></i>
                            <input type="email" name="customer_email" id="customer_email" class="form-control" placeholder="Masukkan email Anda" required>
                        </div>
                        <!-- Button -->
                        <div class="text-center">
                            <button type="submit" name="submit_order" class="btn btn-success btn-lg w-100">Kirim Pesanan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
