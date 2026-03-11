<?php
include 'navbar.php';
include 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Dodavanje novi produkti
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $lokacija_id = $_POST['lokacija_id'];
    $image_name = '';

    // Prikacuvanje na slika
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $image_name = basename($_FILES['product_image']['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . $image_name;

        // Prefrluvanje na slikata vo posakuvanata oblast
        if (!move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file)) {
            echo "<div class='alert alert-danger'>Error uploading the image.</div>";
        }
    }

    // Vnesuvanje na produktot vo bazata na podatoci
    $stmt = $conn->prepare("INSERT INTO products (name, description, quantity, lokacija_id, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('ssiss', $name, $description, $quantity, $lokacija_id, $image_name);
    $stmt->execute();
}

// Nova poracka
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_product'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

   
    $conn->begin_transaction();

    try {
        // Vnesuvanje poracka vo bazata
        $stmt = $conn->prepare("INSERT INTO naracki (product_id, quantity) VALUES (?, ?)");
        $stmt->bind_param('ii', $product_id, $quantity);
        $stmt->execute();
        $stmt->close();

        // Vnesuvanje kolicina na produktot vo bazata
        $update_stmt = $conn->prepare("UPDATE products SET quantity = quantity + ? WHERE id = ?");
        $update_stmt->bind_param('ii', $quantity, $product_id);
        $update_stmt->execute();
        $update_stmt->close();

       
        $conn->commit();

        echo "<div class='alert alert-success'>Order placed successfully, and product quantity updated.</div>";
    } catch (Exception $e) {
        
        $conn->rollback();
        echo "<div class='alert alert-danger'>Error placing order: " . $e->getMessage() . "</div>";
    }
}




$products = $conn->query("
    SELECT products.id, products.name AS product_name, products.description, 
           products.quantity, lokacija.name AS location_name, lokacija.shelf 
    FROM products
    LEFT JOIN lokacija ON products.lokacija_id = lokacija.id
");

// Lokacija za dropdown
$locations = $conn->query("SELECT id, name, shelf FROM lokacija");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add/Order Products</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        
    body {
        background-color: #f4f6f8;
        font-family: 'Arial', sans-serif;
    }
    .container {
        max-width: 1000px;
        background-color: #ffffff; 
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    h1, h3 {
        color: #343a40;
    }
    .form-group label {
        font-weight: bold;
        color: #495057;
    }
    .btn {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        border-radius: 5px;
    }
    .btn-success {
        background-color: #28a745;
        border: none;
    }
    .btn-primary {
        background-color: #007bff;
        border: none;
    }
    .form-control {
        border-radius: 5px;
    }
    .card {
        border: none;
        background-color: #f1f1f1;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .card-title {
        font-size: 1.5rem;
        color: #343a40;
    }
    .card-body {
        padding-top: 10px;
    }
    .card-body p {
        margin: 0 0 10px;
    }
    .row {
        display: flex;
        justify-content: space-between;
    }
    .col-md-6 {
        margin-bottom: 30px;
    }
</style>

    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Додади/Порачи продукт</h1>

    <!-- Form za dodavanje produkti  -->
    <div class="card mb-4">
        <div class="card-body">
            <h3>Додади нов продукт</h3>
            <form method="POST" class="mb-4" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Име на продукт</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="description">Опис на продукт</label>
                    <input type="text" class="form-control" id="description" name="description" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Количина</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" required>
                </div>
                <div class="form-group">
                    <label for="lokacija_id">Избери локација</label>
                    <select class="form-control" id="lokacija_id" name="lokacija_id" required>
                        <?php while ($location = $locations->fetch_assoc()): ?>
                            <option value="<?= $location['id'] ?>">
                                <?= $location['name'] ?> ( <?= $location['shelf'] ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="product_image">Слика на продуктот</label>
                    <input type="file" class="form-control" id="product_image" name="product_image">
                </div>
                <button type="submit" name="add_product" class="btn btn-success">Додади продукт</button>
            </form>
        </div>
    </div>

    <!-- Form za poracuvanje produkti -->
    <div class="card">
        <div class="card-body">
            <h3>Порачи залиха</h3>
            <form method="POST">
                <div class="form-group">
                    <label for="product_id">Одбери продукт</label>
                    <select class="form-control" id="product_id" name="product_id" required>
                        <?php while ($row = $products->fetch_assoc()): ?>
                            <option value="<?= $row['id'] ?>">
                                <?= $row['product_name'] ?> (<?= $row['location_name'] ?> - <?= $row['shelf'] ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Количина на залиха</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" required>
                </div>
                <button type="submit" name="order_product" class="btn btn-primary">Порачи</button>
            </form>
        </div>
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
