<?php
require_once __DIR__ . '/../database/connection.php';



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

$sql = "SELECT 
            menu_items.id,
            menu_items.naam AS item_naam,
            menu_items.beschrijving,
            menu_items.prijs,
            menus.naam AS menu_naam
        FROM 
            menu_items
        INNER JOIN 
            menus ON menu_items.menu_id = menus.id";

$result = $conn->query($sql);
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
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                  <thead class="table-primary">
                    <tr>
                      <th>#</th>
                      <th>Menu</th>
                      <th>Item naam</th>
                      <th>Beschrijving</th>
                      <th>Prijs</th>
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
                            <td colspan="5" class="text-center text-muted">Geen menu items gevonden.</td>
                        </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
