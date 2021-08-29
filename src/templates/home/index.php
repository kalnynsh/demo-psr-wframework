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

<div class="container py-4">
    <div class="h-100 p-5 mb-4 bg-light rounded-3">

        <div class="container-fluid py-5">

            <h1 class="display-5 fw-bold">Greetings</h1>
            <p class="col-md-8 fs-4">
                Hello, <?= htmlspecialchars($name) ?>!    
            </p>
            
        </div>
    </div>
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
