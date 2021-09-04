<?php
/** @var \Framework\Template\TemplateRenderer $this */
?>

<?php $this->extend = 'layout/main'; ?>

<?php $this->params['title'] = 'About'; ?>

<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
    <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
    </a>

    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
    <li><a href="/" class="nav-link px-2 link-dark">Home</a></li>
    <li><a href="/cabinet" class="nav-link px-2 link-dark">Cabinet</a></li>
    <li><a href="#" class="nav-link px-2 link-dark">Pricing</a></li>
    <li><a href="#" class="nav-link px-2 link-dark">FAQs</a></li>
    <li><a href="/about" class="nav-link px-2 link-secondary">About</a></li>
    </ul>

    <div class="col-md-3 text-end">
    <button type="button" class="btn btn-outline-primary me-2">Login</button>
    <button type="button" class="btn btn-primary">Sign-up</button>
    </div>
</header>

<div class="col-lg-8 mx-auto p-3 py-md-5">

    <h1>Description</h1>
    <p class="fs-5 col-md-8">
        <?= $aboutContent ?>
    </p>

</div>

