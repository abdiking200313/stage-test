<?php
require_once __DIR__ . '/../database/connection.php';

$menus = [];
$menuResult = $conn->query("SELECT id, naam FROM menus");
if ($menuResult && $menuResult->num_rows > 0) {
    while ($row = $menuResult->fetch_assoc()) {
        $menus[] = $row;
    }
}

$melding = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = trim($_POST['naam'] ?? '');
    $beschrijving = trim($_POST['beschrijving'] ?? '');
    $prijs = trim($_POST['prijs'] ?? '');
    $menu_id = intval($_POST['menu_id'] ?? 0);

    if ($naam && $beschrijving && $prijs && $menu_id) {
        $stmt = $conn->prepare("INSERT INTO menu_items (naam, beschrijving, prijs, menu_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $naam, $beschrijving, $prijs, $menu_id);
        if ($stmt->execute()) {
            $melding = '<div class="alert alert-success">Menu item succesvol toegevoegd!</div>';
        } else {
            $melding = '<div class="alert alert-danger">Fout bij toevoegen: ' . htmlspecialchars($conn->error) . '</div>';
        }
        $stmt->close();
    } else {
        $melding = '<div class="alert alert-warning">Vul alle velden in.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Menu item toevoegen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <h2>Menu item toevoegen</h2>
    <?= $melding ?>
    <form method="post" class="mt-4" autocomplete="off">
        <div class="mb-3">
            <label for="naam" class="form-label">Naam</label>
            <input type="text" class="form-control" id="naam" name="naam" required>
        </div>
        <div class="mb-3">
            <label for="beschrijving" class="form-label">Beschrijving</label>
            <input type="text" class="form-control" id="beschrijving" name="beschrijving" required>
        </div>
        <div class="mb-3">
            <label for="prijs" class="form-label">Prijs (€)</label>
            <input type="number" step="0.01" min="0" class="form-control" id="prijs" name="prijs" required>
        </div>
        <div class="mb-3">
            <label for="menu_id" class="form-label">Menu</label>
            <select class="form-select" id="menu_id" name="menu_id" required>
                <option value="">Kies een menu...</option>
                <?php foreach ($menus as $menu): ?>
                    <option value="<?= $menu['id'] ?>"><?= htmlspecialchars($menu['naam']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Toevoegen</button>
        <a href="menu_items.php" class="btn btn-secondary">Annuleren</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
