<?php
// Start session
session_start();

// Check if order session exists
if (!isset($_SESSION['order'])) {
    header("Location: index.php"); // Redirect to home if no order data
    exit();
}

// Retrieve order information from session
$order = $_SESSION['order'];

// Handle payment submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pay_now'])) {
    $payment_method = $_POST['payment_method'];

    // Save payment to database
    $host = 'localhost';
    $dbname = 'restaurant_db';
    $username = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert payment data
        $stmt = $pdo->prepare("INSERT INTO payments (payment_method, order_details) VALUES (?, ?)");
        $stmt->execute([$payment_method, $order['order_details']]);

        // Clear session data after payment
        unset($_SESSION['cart'], $_SESSION['order']);

        // Redirect to thank you page
        header("Location: thank_you.php");
        exit();
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <h2 class="text-center mb-4">Pembayaran</h2>

        <!-- Customer Info Section -->
        <div class="mb-4">
            <h5>Customer Information</h5>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Nama</th>
                        <td><?= htmlspecialchars($order['customer_name']) ?></td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td><?= htmlspecialchars($order['customer_phone']) ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= htmlspecialchars($order['customer_email']) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

       <!-- Order Summary Section -->
<section id="order-summary" class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Ringkasan Pesanan</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Pesanan</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $grandTotal = 0;
                foreach ($_SESSION['cart'] as $item): 
                    $totalPrice = $item['price'] * $item['quantity'];
                    $grandTotal += $totalPrice;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td class="text-center"><?= $item['quantity'] ?></td>
                        <td class="text-end">Rp <?= number_format($totalPrice, 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" class="text-end">Total Keseluruhan:</th>
                    <th class="text-end">Rp <?= number_format($grandTotal, 0, ',', '.') ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</section>

<!-- Payment Form Section -->
<!-- Payment Form Section -->
<section id="payment-form" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Metode Pembayaran</h2>
        <form method="POST" class="text-center">
            <div class="d-inline-block text-start">
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="payment_method" id="debit" value="Debit" required>
                    <label class="form-check-label" for="debit">
                        <img src="https://cdn-icons-png.flaticon.com/128/4021/4021708.png" alt="Debit Icon" width="30" class="me-2">Debit
                    </label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="payment_method" id="cash" value="Cash" required>
                    <label class="form-check-label" for="cash">
                        <img src="https://cdn-icons-png.flaticon.com/128/2488/2488749.png" alt="Cash Icon" width="30" class="me-2">Cash
                    </label>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" name="pay_now" class="btn btn-success btn-lg">Bayar Sekarang</button>
            </div>
        </form>
    </div>
</section>
    </div>
</body>
</html>
