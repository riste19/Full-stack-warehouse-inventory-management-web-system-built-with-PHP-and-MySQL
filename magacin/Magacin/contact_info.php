<?php include 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контакт Инфо</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5; 
        }
        .container {
            max-width: 800px;
        }
        h1 {
            font-weight: bold;
            color: #343a40;
            margin-bottom: 20px;
        }
        .contact-info {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .contact-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 350px;
            transition: transform 0.2s;
        }
        .contact-card:hover {
            transform: translateY(-5px);
        }
        .contact-card h5 {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .contact-card p {
            font-size: 1rem;
            margin-bottom: 5px;
        }
        .map-container {
            margin-top: 30px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container mt-5 text-center">
        <h1> Контакт Инфо</h1>
        <p class="lead">Ако имате какви било прашања или потреби, слободно контактирајте не:</p>
        <!--Kontakt blokovi-->
        <div class="contact-info">
            
            <div class="contact-card">
                <h5>👤 Ристе Семенковски</h5>
                <p><strong>📧 Email:</strong> riste.102741@student.ugd.edu.mk</p>
                <p><strong>📱 Телефон:</strong> 077 565 558</p>
            </div>

           
            <div class="contact-card">
                <h5>👤 Филип Депинов</h5>
                <p><strong>📧 Email:</strong> filip.102701@student.ugd.edu.mk</p>
                <p><strong>📱 Телефон:</strong> 075 806 070</p>
            </div>
        </div>

    <!--Google maps implementacija -->
        <div class="map-container">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d11911.5080919164!2d22.626310!3d41.455365!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sus!4v1617110112403!5m2!1sen!2sus" 
                width="100%" 
                height="400" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy">
            </iframe>
        </div>
    </div>
</body>
</html>

