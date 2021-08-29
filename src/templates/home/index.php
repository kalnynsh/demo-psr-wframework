<?php

/** @var string $topLayout  */
$topLayout = dirname(__DIR__)
    . DIRECTORY_SEPARATOR
    . 'layout'
    . DIRECTORY_SEPARATOR
    . 'main_top.php';

require_once $topLayout;

/** @var string $header  */
$header = dirname(__DIR__)
    . DIRECTORY_SEPARATOR
    . 'layout'
    . DIRECTORY_SEPARATOR
    . 'header.php';

require_once $header;

?>

<main class="container">
    <section class="row">
        <div class="col-12 col-md-auto">
            <h1>Greetings</h1>
            <p>Hello, <?= htmlspecialchars($name) ?>!</p>
        </div>        
    </section>
</main>

<?php

/** @var string $bottemLayout */
$bottemLayout = dirname(__DIR__)
    . DIRECTORY_SEPARATOR
    . 'layout'
    . DIRECTORY_SEPARATOR
    . 'main_bottem.php';

require_once $bottemLayout;

?>
