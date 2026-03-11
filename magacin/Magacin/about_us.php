<?php include 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .about-section {
            position: relative;
            background: url('assets/magacin2.jpg') no-repeat center center/cover;
            height: 100vh;
            color: white;
            display: flex;
            align-items: center;
        }
        .about-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, rgba(0, 0, 50, 0.7), rgba(255, 0, 0, 0.3));
        }
        .about-content {
            position: relative;
            z-index: 1;
            max-width: 600px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="about-section">
        <div class="about-overlay"></div>
        <div class="container">
            <div class="about-content">
                <h1 class="display-4"> За нашиот магацин </h1>
                <p class="lead">Добре дојдовте во F & R Warehouse, водечкиот капацитет за складирање на ИТ производи. 
                    Постоиме од 2003 година и обезбедуваме магацин за сите можни IT продукти. 
                    Нашиот најсовремен капацитет обезбедува безбедно и ефикасно складирање, што нè прави доверлив партнер за бизнисите кои сакаат беспрекорно да управуваат со својот ИТ инвентар.</p>
                <p>Сакате да ги истражите нашите моментални продукти? Кликнете на копчето подолу за да ги разгледате нашите најнови ИТ продукти.</p>
                <a href="browse_products.php" class="btn btn-danger"> Прегледај ја нашата залиха </a>
            </div>
        </div>
    </div>
</body>
</html>
