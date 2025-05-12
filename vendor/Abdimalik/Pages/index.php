<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Homepagina met Bootstrap</title>
  <!-- Bootstrap CSS -->
  <link href="./../assets/bootstrap-5.3.6-dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
</head>
<body>

    <?php include 'navbar.php'; ?>

  <!-- Hero sectie -->
  <header class="bg-light py-5">
    <div class="container text-center">
      <h1 class="display-4">Welkom op mijn website</h1>
      <p class="lead mb-4">Een eenvoudige en mooie startpagina gebouwd met Bootstrap.</p>
      <a href="#" class="btn btn-primary btn-lg">Meer informatie</a>
    </div>
  </header>

  <!-- Content sectie -->
  <section class="py-5">
    <div class="container">
      <div class="row text-center">
        <div class="col-md-4">
          <h3>Dienst 1</h3>
          <p>Beschrijving van dienst 1.</p>
        </div>
        <div class="col-md-4">
          <h3>Dienst 2</h3>
          <p>Beschrijving van dienst 2.</p>
        </div>
        <div class="col-md-4">
          <h3>Dienst 3</h3>
          <p>Beschrijving van dienst 3.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-primary text-white text-center py-3">
    <div class="container">
      &copy; 2025 MijnSite. Alle rechten voorbehouden.
    </div>
  </footer>

  <!-- Bootstrap JS Bundle (met Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
