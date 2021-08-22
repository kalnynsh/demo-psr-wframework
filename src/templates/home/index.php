<?php

/** @var string $topLayout  */
$topLayout = dirname(__DIR__)
    . DIRECTORY_SEPARATOR
    . 'layout'
    . DIRECTORY_SEPARATOR
    . 'main_top.php';

require_once $topLayout;

?>



<main class="container">
    <section class="row">
        <h1>Greetings</h1>
        <p>Hello, <?= $name ; ?>!</p>
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
