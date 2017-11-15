<?php

use yeesoft\helpers\Url;
use yeesoft\helpers\Html;
use yeesoft\widgets\ActiveForm;

/* @var $this \yii\web\View */

$this->title = Yii::t('yee/translation', 'Message Translation');
$this->params['breadcrumbs'][] = $this->title;
$this->params['description'] = 'YeeCMS 0.2.0';
$this->params['header-content'] = Html::a(Yii::t('yee/translation', 'Add New Source Message'), ['source/create'], ['class' => 'btn btn-sm btn-primary']);
?>

<div class="row">
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-body">
                <ul class="nav nav-pills nav-stacked">
                    <?php foreach ($categories as $category => $count) : ?>
                        <li role="presentation" class="<?= ($category === $currentCategory) ? 'active' : '' ?>">
                            <?= Html::beginTag('a', ['href' => Url::to(['index', 'category' => $category])]) ?>
                            <b><?= strtoupper($category) ?></b> 
                            <span class="badge">
                                <?= Yii::t('yee/translation', '{n, plural, =1{1 message} other{# messages}}', ['n' => $count]) ?>
                            </span>
                            <?= Html::endTag('a') ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <?php foreach ($languages as $language => $languageLabel) : ?>
                    <li class="<?= ($language === $currentLanguage) ? 'active' : '' ?>">
                        <?php $link = ['index', 'category' => $category, 'translation' => $language] ?>
                        <?= Html::beginTag('a', ['href' => Url::to(['index', 'category' => $currentCategory, 'translation' => $language])]) ?>
                        <?= $languageLabel ?>
                        <span class="badge">
                            <?= $language ?>
                        </span>
                        <?= Html::endTag('a') ?>
                    </li>
                <?php endforeach; ?>

            </ul>
            <div class="tab-content">
                <div class="tab-pane active">
                    <?php $form = ActiveForm::begin() ?>

                    <?php foreach ($messages as $index => $message) : ?>
                        <?php if ($sourceLanguage === $currentLanguage) : ?>
                            <?= $this->render('_source', compact('form', 'index', 'message')) ?>
                        <?php else : ?>
                            <?= $this->render('_translation', compact('form', 'index', 'message')) ?>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <?php if ($sourceLanguage !== $currentLanguage && Yii::$app->user->can('update-source-messages')) : ?>
                        <div class="text-right">
                            <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary', 'style' => 'min-width: 140px;']) ?>
                        </div>
                    <?php endif; ?>

                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>