<?php
/** @var \Framework\Template\TemplateRenderer $this */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css"
      rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We"
      crossorigin="anonymous" />
    <title><?= $this->params['title'] ?? '' ?></title>
</head>
<body>

  <div class="h-100">

    <?= $content ?>

    <div class="container bg-light">
      <footer class="footer mt-auto d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">

        <div class="col-md-4 d-flex align-items-center">
          <a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
            <svg class="bi" width="30" height="24"><use xlink:href="#bootstrap"></use></svg>
          </a>
          <span class="text-muted">&copy; 2021 PSR-7 Demo</span>
        </div>

        <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
          <li class="ms-3"><a class="text-muted" href="#">Twitter</a></li>
          <li class="ms-3"><a class="text-muted" href="#">Instagram</a></li>
          <li class="ms-3"><a class="text-muted" href="#">Facebook</a></li>
        </ul>

      </footer>
    </div>

  </div>

  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj"
    crossorigin="anonymous">
  </script>

</body>
</html>
