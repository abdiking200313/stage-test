<?php
require_once __DIR__ . '/../database/connection.php';


$melding = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = trim($_POST['naam'] ?? '');
    $beschrijving = trim($_POST['beschrijving'] ?? '');



    if ($naam && $beschrijving ) {
        $stmt = $conn->prepare("INSERT INTO menus (naam, beschrijving) VALUES (?, ?)");
        $stmt->bind_param("ss", $naam, $beschrijving);
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

        <button type="submit" class="btn btn-primary">Toevoegen</button>
        <a href="menu.php" class="btn btn-secondary">Terug</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
