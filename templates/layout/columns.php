<?php
/** @var \Framework\Template\TemplateRenderer $this */
?>
<?php $this->extend('layout/main'); ?>

<?php $this->blockBegin('content'); ?>

    <div class="container-fluid">

        <div class="row">

            <?= $this->blockRender('leftSidebar'); ?>

            <?= $this->blockRender('description'); ?>

        </div>

    </div>

<?php $this->blockEnd(); ?>