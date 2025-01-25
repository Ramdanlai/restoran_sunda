<?php
// Start session
session_start();

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

// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];

    $itemIndex = array_search($name, array_column($_SESSION['cart'], 'name'));
    if ($itemIndex !== false) {
        $_SESSION['cart'][$itemIndex]['quantity'] += 1;
    } else {
        $_SESSION['cart'][] = ['name' => $name, 'price' => $price, 'quantity' => 1];
    }
}

// Handle delete from cart
if (isset($_GET['delete_item'])) {
    $itemIndex = $_GET['delete_item'];
    unset($_SESSION['cart'][$itemIndex]);
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

// Handle updating cart item quantity
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $index => $quantity) {
        $_SESSION['cart'][$index]['quantity'] = max(1, intval($quantity));
    }
}

// Fetch menu items from the database
$stmt = $pdo->query("SELECT * FROM menu_items");
$menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate total items in cart
$totalItems = array_sum(array_column($_SESSION['cart'], 'quantity'));


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dapur Ngebul</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="./img/th-removebg-preview.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
            Dapur Ngebul
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#home">Halaman</a></li>
                <li class="nav-item"><a class="nav-link" href="#menu">Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="#cart">Pesanan (<?= $totalItems ?>)</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Komplain</a></li>
            </ul>
        </div>
    </div>
</nav>


    <!-- Hero Section -->
    <section id="home">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <!-- Carousel Indicators -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

        <!-- Carousel Items -->
        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active">
                <img src="./img/sunda.jpeg" class="d-block w-100" alt="Slide 1">
                <div class="carousel-caption d-none d-md-block">
                    <h1>Sampurasun</h1>
                    <h5>Temukan pengalaman seperti di pedesaan</h5>
                    <a href="#menu" class="btn btn-primary btn-lg">Pesan Sekarang</a>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item">
                <img src="./img/6 Rekomendasi Rumah Makan Sunda yang Terkenal Enak.jpeg" class="d-block w-100" alt="Slide 2">
                <div class="carousel-caption d-none d-md-block">
                    <h1>Masakan Khas Sunda</h1>
                    <p>Menghidangkan Masakan Sunda Yang Otentik</p>
                    <a href="#menu" class="btn btn-primary btn-lg">Menu</a>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item">
                <img src="./img/download.jpeg" class="d-block w-100" alt="Slide 3">
                <div class="carousel-caption d-none d-md-block">
                    <h1>Teman ngopi dan juga kesegaran</h1>
                    <p>Berbagai Kesegaran dan juga kehangatan yang rindu akan desa</p>
                    <a href="#menu" class="btn btn-primary btn-lg">Menu</a>
                </div>
            </div>
        </div>

        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>


    <!-- Menu Section -->
<section id="menu" class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Menu</h2>

        <!-- Fetch and display Makanan -->
        <h3 id="makanan" class="mb-3">Makanan</h3>
        <div class="row">
            <?php
            $stmt = $pdo->query("SELECT * FROM menu_items WHERE category = 'Makanan'");
            while ($item = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="image-container">
                            <img src="<?= $item['image_url'] ?>" class="card-img-top" alt="<?= htmlspecialchars($item['name']) ?>">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($item['name']) ?></h5>
                            <p class="text-primary">Rp <?= number_format($item['price'], 0, ',', '.') ?></p>
                            <form method="POST" action="#makanan">
                                <input type="hidden" name="name" value="<?= htmlspecialchars($item['name']) ?>">
                                <input type="hidden" name="price" value="<?= htmlspecialchars($item['price']) ?>">
                                <button type="submit" name="add_to_cart" class="btn btn-primary">Pesan</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Fetch and display Minuman -->
        <h3 id="minuman" class="mb-3">Minuman</h3>
        <div class="row">
            <?php
            $stmt = $pdo->query("SELECT * FROM menu_items WHERE category = 'Minuman'");
            while ($item = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="image-container">
                            <img src="<?= $item['image_url'] ?>" class="card-img-top" alt="<?= htmlspecialchars($item['name']) ?>">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($item['name']) ?></h5>
                            <p class="text-primary">Rp <?= number_format($item['price'], 0, ',', '.') ?></p>
                            <form method="POST" action="#minuman">
                                <input type="hidden" name="name" value="<?= htmlspecialchars($item['name']) ?>">
                                <input type="hidden" name="price" value="<?= htmlspecialchars($item['price']) ?>">
                                <button type="submit" name="add_to_cart" class="btn btn-primary">Pesan</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Fetch and display Dessert -->
        <h3 id="dessert" class="mb-3">Dessert</h3>
        <div class="row">
            <?php
            $stmt = $pdo->query("SELECT * FROM menu_items WHERE category = 'Dessert'");
            while ($item = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="image-container">
                            <img src="<?= $item['image_url'] ?>" class="card-img-top" alt="<?= htmlspecialchars($item['name']) ?>">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($item['name']) ?></h5>
                            <p class="text-primary">Rp <?= number_format($item['price'], 0, ',', '.') ?></p>
                            <form method="POST" action="#dessert">
                                <input type="hidden" name="name" value="<?= htmlspecialchars($item['name']) ?>">
                                <input type="hidden" name="price" value="<?= htmlspecialchars($item['price']) ?>">
                                <button type="submit" name="add_to_cart" class="btn btn-primary">Pesan</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
   <!-- Cart Section -->
<section id="cart" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Pesanan Anda</h2>
        <?php if (empty($_SESSION['cart'])): ?>
            <p class="text-center">Anda Belum Memesan.</p>
        <?php else: ?>
            <form method="POST" action="customer_info.php">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Pesanan</th>
                            <th>Harga</th>
                            <th>Banyaknya</th>
                            <th>Total</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['name']) ?></td>
                                <td>Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></td>

                                <td>
                                    <input type="number" name="quantity[<?= $index ?>]" value="<?= $item['quantity'] ?>" min="1" class="form-control">
                                </td>
                                <td>Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></td>
                                <td>
                                <div class="btn-group">
                                        <button type="submit" name="update_cart" class="btn btn-warning btn-sm me-2">Update</button>
                                        <a href="?delete_item=<?= $index ?>" class="btn btn-danger btn-sm">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="text-center">
                <a href="customer_info.php" class="btn btn-success">Proses Pesanan</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</section>




    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Komplain</h2>
            <form method="POST" action="contact_handler.php" class="w-50 mx-auto">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Anda</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Anda</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Pesan</label>
                    <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Kirim Pesan</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p class="mb-0">&copy; <?= date('Y') ?> Dapur Ngebul. Mengobati Rindu Pedesaan.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
