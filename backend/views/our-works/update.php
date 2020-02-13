<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OurWorks */

$this->title = 'Update Our Works: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Our Works', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="our-works-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
