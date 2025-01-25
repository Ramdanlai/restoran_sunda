<?php
require 'vendor/autoload.php'; // Autoload Dompdf

use Dompdf\Dompdf;
use Dompdf\Options;

// Start session
session_start();

// Check if order exists
if (!isset($_SESSION['order'])) {
    die("No order data available to generate PDF.");
}

// Retrieve order details
$order = $_SESSION['order'];
$orderDetails = json_decode($order['order_details'], true);

// Generate HTML for the PDF
$html = "
<h2>Order Receipt</h2>
<p><strong>Name:</strong> " . htmlspecialchars($order['customer_name']) . "</p>
<p><strong>Phone:</strong> " . htmlspecialchars($order['customer_phone']) . "</p>
<p><strong>Email:</strong> " . htmlspecialchars($order['customer_email']) . "</p>
<h3>Order Summary:</h3>
<ul>";

foreach ($orderDetails as $item) {
    $html .= "<li>" . htmlspecialchars($item['name']) . " (x" . htmlspecialchars($item['quantity']) . ") - $"
        . number_format($item['price'] * $item['quantity'], 2) . "</li>";
}

$html .= "</ul>
<p><strong>Total:</strong> $" . array_sum(array_map(function ($item) {
        return $item['price'] * $item['quantity'];
    }, $orderDetails)) . "</p>";

// Initialize Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true); // Enable remote content like images
$dompdf = new Dompdf($options);

// Load HTML into Dompdf
$dompdf->loadHtml($html);

// Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the PDF
$dompdf->render();

// Output the PDF for download
$dompdf->stream("Order_Receipt.pdf", ["Attachment" => true]);
