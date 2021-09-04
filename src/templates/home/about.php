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

<div class="col-lg-8 mx-auto p-3 py-md-5">

    <main>

        <h1>Description</h1>
        <p class="fs-5 col-md-8">
            <?= $aboutContent ?>
        </p>

    </main>

</div>

<?php

/** @var string $bottemLayout */
$footer = dirname(__DIR__)
    . DIRECTORY_SEPARATOR
    . 'layout'
    . DIRECTORY_SEPARATOR
    . 'footer.php';

require_once $footer;


/** @var string $bottemLayout */
$bottemLayout = dirname(__DIR__)
    . DIRECTORY_SEPARATOR
    . 'layout'
    . DIRECTORY_SEPARATOR
    . 'main_bottem.php';

require_once $bottemLayout;

?>
