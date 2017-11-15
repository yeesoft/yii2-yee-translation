<?php

use yeesoft\helpers\Html;

/* @var $this yeesoft\web\View */
?>

<div class="form-group">
    <label class="control-label"><?= $message->message ?></label>
    <div class="input-group">

        <?= Html::textInput(null, $message->message, ['class' => 'form-control', 'readonly' => 'readonly']) ?>

        <div class="input-group-btn">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-right">
                <li>
                    <?= Html::a('Update', ['source/update', 'id' => $message->id]) ?>
                </li>
                <li>
                    <?= Html::a('Delete', ['source/delete', 'id' => $message->id], [
                        'data' => [
                            'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ]
                    ]) ?>
                </li>
            </ul>
        </div>
    </div>
</div>