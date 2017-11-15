<?php

/* @var $this yii\web\View */
/* @var $model yeesoft\translation\models\MessageSource */

$this->title = Yii::t('yee/translation', 'Create Message Source');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/translation', 'Message Translation'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', compact('model')) ?>