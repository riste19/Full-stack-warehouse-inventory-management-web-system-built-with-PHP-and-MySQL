    <?php
    include 'navbar.php';
    include 'db.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Proveruva dali userot e logiran
    $isLoggedIn = isset($_SESSION['user_id']);

    // zimame podatoci od databazata lokacija
    $locationFilters = [];
    $result = $conn->query("SELECT DISTINCT l.name, l.shelf FROM lokacija l ORDER BY l.name, l.shelf");
    while ($row = $result->fetch_assoc()) {
        $locationFilters[$row['name'] . ' - ' . $row['shelf']] = $row['name'] . ' Raft ' . $row['shelf'];
    }

    // Sortiranje
    $sortingOptions = [
        'name_asc' => 'Име (A-Z)',
        'name_desc' => 'Име (Z-A)',
        'quantity_asc' => 'Количина (мала-голема)',
        'quantity_desc' => 'Количина (голема-мала)'
    ];

    
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'name_asc'; 
    $orderBy = "p.name ASC"; 
    if ($sort === 'name_desc') {
        $orderBy = "p.name DESC";
    } elseif ($sort === 'quantity_asc') {
        $orderBy = "p.quantity ASC";
    } elseif ($sort === 'quantity_desc') {
        $orderBy = "p.quantity DESC";
    }

    // filtriranje na lokacija
    $filter = isset($_GET['filter']) ? $_GET['filter'] : '';
    $filterQuery = '';
    if (!empty($filter)) {
        [$locationName, $shelf] = explode(' - ', $filter);
        $locationName = $conn->real_escape_string($locationName);
        $shelf = $conn->real_escape_string($shelf);
        $filterQuery = "AND l.name = '$locationName' AND l.shelf = '$shelf'";
    }

    // Prebaruvanje
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $searchQuery = $search ? "AND p.name LIKE '%" . $conn->real_escape_string($search) . "%'" : '';

    
    $productsPerPage = 12;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $productsPerPage;

    
    $query = "
        SELECT 
            p.name, 
            p.description, 
            p.quantity, 
            l.name AS location_name, 
            l.shelf, 
            p.image 
        FROM products p
        LEFT JOIN lokacija l ON p.lokacija_id = l.id
        WHERE 1=1 
        $searchQuery
        $filterQuery
        ORDER BY $orderBy
        LIMIT $productsPerPage OFFSET $offset
    ";

    
    $sortedProducts = $conn->query($query);

    
    $totalQuery = "
        SELECT COUNT(*) AS total FROM products p
        LEFT JOIN lokacija l ON p.lokacija_id = l.id
        WHERE 1=1 
        $searchQuery
        $filterQuery
    ";
    $totalResult = $conn->query($totalQuery);
    $totalRow = $totalResult->fetch_assoc();
    $totalProducts = $totalRow['total'];
    $totalPages = ceil($totalProducts / $productsPerPage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пребарај продукти</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    body {
        background-color: #f4f6f8; 
        font-family: 'Arial', sans-serif;
    }

   
    .controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        background-color: #ffffff; 
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

   
    .controls form {
        display: flex;
        width: 100%;
    }

    .controls .form-control {
        margin-right: 10px;
        flex: 1; 
    }

    .controls .form-control:last-child {
        margin-right: 0; 
    }

    .search-bar input {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ced4da;
    }

    
    .card {
        height: 100%;
        display: flex;
        flex-direction: column;
        background-color: #f1f1f1; 
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-img-top {
        height: 200px;
        object-fit: contain;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    .card-body p {
        margin-bottom: 10px;
        color: #495057;
    }

    .card-title {
        font-size: 1.5rem;
        color: #343a40;
    }

   
    .pagination {
        margin-top: 20px;
        justify-content: center;
        display: flex;
    }

    .pagination .page-link {
        background-color: #ffffff;
        border: 1px solid #ddd;
        color: #007bff;
        padding: 10px 15px;
        margin: 0 5px;
        border-radius: 5px;
    }

    .pagination .page-link:hover {
        background-color: #007bff;
        color: #ffffff;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        color: #ffffff;
    }

    
    .container {
        max-width: 1000px;
        background-color: #ffffff; 
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

    
    .row {
        display: flex;
        justify-content: space-between;
    }

    .col-md-4 {
        margin-bottom: 30px;
    }

    .col-md-6 {
        margin-bottom: 30px;
    }
</style>


    
</head>
<body>
    <div class="container mt-5">
    <h1 class="mb-4 text-center">Пребарај Продукти</h1>

        
        <div class="controls">
            <form method="GET" class="form-inline">
                <!-- Sortiranje dropdown -->
                <select name="sort" class="form-control" onchange="this.form.submit()">
                    <?php foreach ($sortingOptions as $key => $label): ?>
                        <option value="<?= $key ?>" <?= $sort === $key ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Lokacija Dropdown -->
                <select name="filter" class="form-control ml-2" onchange="this.form.submit()">
                    <option value="">Сите локации</option>
                    <?php foreach ($locationFilters as $key => $label): ?>
                        <option value="<?= $key ?>" <?= $filter === $key ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                
                <div class="search-bar ml-3">
                    <input 
                        type="text" 
                        class="form-control" 
                        name="search" 
                        placeholder="Пребарај продукти..." 
                        value="<?= htmlspecialchars($search) ?>"
                    >
                </div>
            </form>
        </div>

        <!-- Prikazi Produkti -->
        <div class="row">
            <?php if ($sortedProducts && $sortedProducts->num_rows > 0): ?>
                <?php while ($row = $sortedProducts->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img 
                                src="<?= htmlspecialchars('uploads/' . $row['image']) ?>" 
                                class="card-img-top" 
                                alt="Product Image" 
                                style="height: 200px; object-fit: contain;"
                            >
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($row['description']) ?></p>
                                <p class="card-text"><strong>Количина:</strong> <?= htmlspecialchars($row['quantity']) ?></p>
                                <p class="card-text"><strong>Локација:</strong> <?= htmlspecialchars($row['location_name'] ?? 'N/A') ?></p>
                                <p class="card-text"><strong>Рафт:</strong> <?= htmlspecialchars($row['shelf'] ?? 'N/A') ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-muted">Nе се најдени производи.</p>
            <?php endif; ?>
        </div>

        
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>&sort=<?= $sort ?>&filter=<?= $filter ?>&search=<?= htmlspecialchars($search) ?>">Претходно</a></li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&sort=<?= $sort ?>&filter=<?= $filter ?>&search=<?= htmlspecialchars($search) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($page < $totalPages): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>&sort=<?= $sort ?>&filter=<?= $filter ?>&search=<?= htmlspecialchars($search) ?>">Следно</a></li>
                <?php endif; ?>
            </ul>
        </nav>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

