<?php
/** @var \Framework\Template\TemplateRenderer $this */
?>
<?php $this->extend('layout/main'); ?>

<div class="container-fluid">

    <div class="row">

        <?= $this->blockRender('leftSidebar'); ?>

        <div class="col-lg-8 mx-auto p-3 py-md-5">
            <?= $content ?>
        </div>

    </div>

</div>
