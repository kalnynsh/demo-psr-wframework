<?php
/** @var \Framework\Template\TemplateRenderer $this */
?>

<?php $this->extend('layout/main'); ?>

<?php $this->params['title'] = 'Cabinet'; ?>

<div class="nav-scroller py-1 mb-2">
    <nav class="nav d-flex justify-content-between">
      <a class="p-2 link-secondary" href="/">Home</a>
      <a class="p-2 link-secondary" href="/about">About</a>
      <a class="p-2 link-dark active" href="#">Cabinet</a>
    </nav>
</div>

<h1>Cabinet</h1>
<p class="fs-5">
    Hello, <?= htmlspecialchars($username, ENT_QUOTES | ENT_SUBSTITUTE) ?>!
</p>
