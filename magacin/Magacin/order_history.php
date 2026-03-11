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

// Zima podatoci od 'naracki' tabelata
$query = "
    SELECT 
        n.id AS order_id, 
        p.name AS product_name, 
        p.description AS product_description, 
        p.quantity AS available_quantity,
        l.name AS location_name, 
        l.shelf,
        n.quantity AS ordered_quantity, 
        n.order_date 
    FROM naracki n
    JOIN products p ON n.product_id = p.id
    LEFT JOIN lokacija l ON p.lokacija_id = l.id
    ORDER BY n.order_date DESC
";
$result = $conn->query($query);

if (!$result) {
    die("Error in SQL Query: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5; 
        }
        .container {
            max-width: 900px;
        }
        .order-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            background: white;
            padding: 20px;
            margin-bottom: 20px;
        }
        .order-card:hover {
            transform: translateY(-5px);
        }
        .order-card h5 {
            font-size: 1.3rem;
            font-weight: bold;
            color: #343a40;
        }
        .order-card p {
            font-size: 1rem;
            margin-bottom: 5px;
        }
        .text-muted {
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center"> Историја на порачки </h1>

        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="order-card">
                    <h5>Порачка : <?= htmlspecialchars($row['order_id']) ?></h5>
                    <p><strong> Име на продукт:</strong> <?= htmlspecialchars($row['product_name']) ?></p>
                    <p><strong> Опис:</strong> <?= htmlspecialchars($row['product_description']) ?></p>
                    <p><strong> Количина на порачена залиха:</strong> <?= htmlspecialchars($row['ordered_quantity']) ?></p>
                    <p><strong> Достапна количина:</strong> <?= htmlspecialchars($row['available_quantity']) ?></p>
                    <p><strong> Локација:</strong> <?= htmlspecialchars($row['location_name'] ?? 'N/A') ?></p>
                    <p><strong> Рафт:</strong> <?= htmlspecialchars($row['shelf'] ?? 'N/A') ?></p>
                    <p><strong> Дата на порачка:</strong> <?= htmlspecialchars($row['order_date']) ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-muted text-center">Не се пронајдени порачки. </p>
        <?php endif; ?>
    </div>
</body>
</html>
