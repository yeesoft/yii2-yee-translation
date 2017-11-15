<?php

/* @var $this yii\web\View */
/* @var $model yeesoft\translation\models\MessageSource */

$this->title = Yii::t('yee', 'Update "{item}"', ['item' => $model->message]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/translation', 'Message Translation'), 'url' => ['/translation/default/index']];
$this->params['breadcrumbs'][] = Yii::t('yee/translation', 'Update Message Source');
?>

<?= $this->render('_form', compact('model')) ?>