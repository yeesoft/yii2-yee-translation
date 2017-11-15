<?php

use yii\web\View;
use yii\helpers\ArrayHelper;
use yeesoft\helpers\Html;
use yeesoft\widgets\ActiveForm;
use yeesoft\translation\models\MessageSource;

/* @var $this yii\web\View */
/* @var $model yeesoft\translation\models\MessageSource */
/* @var $form yeesoft\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(['enableClientValidation' => false]) ?>

<div class="row">
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-body">

                <div class="row">
                    <div class="col-md-6">
                        <?php $categories = ArrayHelper::merge(MessageSource::getCategories(), [' ' => Yii::t('yee/translation', 'Create New Category')]) ?>
                        <?= $form->field($model, 'category')->dropDownList($categories, ['prompt' => '']) ?>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group new-category-group" style="display:none">
                            <label class="control-label" for="new-category"><?= Yii::t('yee/translation', 'New Category Name') ?></label>
                            <input type="text" id="new-category" class="form-control" name="category" value="<?= Yii::$app->getRequest()->post('category') ?>" >
                        </div>
                    </div>
                </div>

                <?= $form->field($model, 'message')->textInput(['rows' => 6]) ?>

            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <?php if ($model->isNewRecord): ?>
                        <div class="col-md-6">
                            <?= Html::submitButton(Yii::t('yee', 'Create'), ['class' => 'btn btn-primary btn-block']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= Html::a(Yii::t('yee', 'Cancel'), ['default/index'], ['class' => 'btn btn-default btn-block']) ?>
                        </div>
                    <?php else: ?>
                        <div style="padding: 0 10px;">
                            <div class="callout callout-warning">
                                <h4><i class="icon fa fa-warning"></i> Warning!</h4>
                                <p class="text-justify">
                                    <?= Yii::t('yee/translation', 'Source messages are used in the source code. For the proper translation of messages you also have to change the source code. Update source messages only if you are sure of what you are doing.') ?>
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <?=
                            Html::submitButton(Yii::t('yee', 'Save'), [
                                'class' => 'btn btn-primary btn-block',
                                'data' => [
                                    'confirm' => Yii::t('yii', 'Are you sure you want to update this source message?'),
                                ],
                            ])
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?=
                            Html::a(Yii::t('yee', 'Delete'), ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-default btn-block',
                                'data' => [
                                    'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'method' => 'post',
                                ],
                            ])
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>

<?php ActiveForm::end(); ?>

<?php
$this->registerJs("

    if($('#messagesource-category').val() !== ' '){
        $('.new-category-group').hide();
    } else {
        $('.new-category-group').show();
    }

    if($('#new-category').val().length > 0){
        $('.new-category-group').show();
        $('#messagesource-category option').last().attr('selected','selected');
        $('#messagesource-category').trigger('refresh');
    }

    $('#messagesource-category').change(function(){
        if($(this).val() !== ' '){
            $('.new-category-group').hide();
        } else {
            $('.new-category-group').show();
        }
    });
", View::POS_READY);
?>