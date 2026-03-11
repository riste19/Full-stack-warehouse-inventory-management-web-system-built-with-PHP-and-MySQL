<?php
session_start();
$currentPage = basename($_SERVER['PHP_SELF']); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="about_us.php">
    <img src="assets/logo.jfif" alt="Warehouse Logo" style="height: 60px;">
</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?= $currentPage == 'about_us.php' ? 'active' : '' ?>">
                    <a class="nav-link" href="about_us.php">За Нас</a>
                </li>
                <li class="nav-item <?= $currentPage == 'browse_products.php' ? 'active' : '' ?>">
                    <a class="nav-link" href="browse_products.php">Пребарување продукти</a>
                </li>
                <li class="nav-item <?= $currentPage == 'add_product.php' || $currentPage == 'index.php' ? 'active' : '' ?>">
                    <a class="nav-link" href="index.php">Додади/Порачи продукт</a>
                </li>
                <li class="nav-item <?= $currentPage == 'order_history.php' ? 'active' : '' ?>">
                    <a class="nav-link" href="order_history.php">Историја на порачки</a>
                </li>
                <li class="nav-item <?= $currentPage == 'contact_info.php' ? 'active' : '' ?>">
                    <a class="nav-link" href="contact_info.php">Контакт инфо</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item">
                        <span class="navbar-text">
                            Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-danger ml-2" href="logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</body>
</html>

