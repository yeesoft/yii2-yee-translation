<?php
/* @var $this \yii\web\View */
?>

<div class="form-group">
    <label class="control-label"><?= $message->source->message ?></label>
    <?= $form->field($message, "[{$index}]translation", ['template' => '{input}']) ?>
</div>