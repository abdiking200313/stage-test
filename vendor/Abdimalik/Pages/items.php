<?php
require_once __DIR__ . '/../database/connection.php';


$menus = [];
$menuResult = $conn->query("SELECT id, naam FROM menus");
if ($menuResult && $menuResult->num_rows > 0) {
    while ($row = $menuResult->fetch_assoc()) {
        $menus[] = $row;
    }
}


if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM menu_items WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success text-center mb-0">Menu item succesvol verwijderd.</div>';
    } else {
        echo '<div class="alert alert-danger text-center mb-0">Fout bij verwijderen: ' . htmlspecialchars($conn->error) . '</div>';
    }
    $stmt->close();
}


$filter_menu = isset($_GET['menu_id']) ? intval($_GET['menu_id']) : 0;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';


$where = [];
$params = [];
$types = '';

if ($filter_menu) {
    $where[] = 'menu_items.menu_id = ?';
    $params[] = $filter_menu;
    $types .= 'i';
}
if ($search) {
    $where[] = '(menu_items.naam LIKE ? OR menu_items.beschrijving LIKE ?)';
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types .= 'ss';
}
$where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';


$sql = "SELECT 
            menu_items.id,
            menu_items.naam AS item_naam,
            menu_items.beschrijving,
            menu_items.prijs,
            menus.naam AS menu_naam
        FROM 
            menu_items
        INNER JOIN 
            menus ON menu_items.menu_id = menus.id
        $where_sql
        ORDER BY menu_items.id DESC";

$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menu Items | Mijn Restaurant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Menu Items</h2>
            <a href="menu_item_toevoegen.php" class="btn btn-success">Nieuw menu item</a>
        </div>

            <div class="card mt-4 mb-4">
  <div class="card-body">
    <form class="row g-3" method="get" action="">
      <div class="col-md-4">
        <select name="menu_id" class="form-select">
          <option value="0">Alle menu's</option>
          <?php foreach($menus as $menu): ?>
            <option value="<?= $menu['id'] ?>" <?= $filter_menu == $menu['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($menu['naam']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Zoeken op naam of beschrijving" value="<?= htmlspecialchars($search) ?>">
      </div>
      <div class="col-md-4">
        <button type="submit" class="btn btn-primary">Filteren</button>
        <a href="items.php" class="btn btn-secondary">Reset</a>
      </div>
    </form>
  </div>
</div>

       <table class="table table-striped mb-0">
  <thead class="table-primary">
    <tr>
      <th>#</th>
      <th>Menu</th>
      <th>Item naam</th>
      <th>Beschrijving</th>
      <th>Prijs</th>
      <th>Acties</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['menu_naam']) ?></td>
            <td><?= htmlspecialchars($row['item_naam']) ?></td>
            <td><?= htmlspecialchars($row['beschrijving']) ?></td>
            <td>&euro; <?= number_format($row['prijs'], 2, ',', '.') ?></td>
                            <td><a href="?delete=<?= $row['id'] ?>" 
                 class="btn btn-sm btn-danger"
                 onclick="return confirm('Weet je zeker dat je dit item wilt verwijderen?');">
                 Verwijder
              </a></td>
          </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="6" class="text-center text-muted">Geen menu items gevonden.</td>
        </tr>
    <?php endif; ?>
  </tbody>
</table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
