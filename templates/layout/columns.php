<?php
/** @var \Framework\Template\TemplateRenderer $this */
?>
<?php $this->extend = 'layout/main'; ?>

<div class="row">
    <div class="col-md-9">
        <?= $content ?>
    </div>
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">Cabinet</div>
            <div class="panel-body">
                Cabinet navigation
            </div>
        </div>
    </div>
</div>
