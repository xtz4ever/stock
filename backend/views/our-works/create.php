<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\OurWorks */

$this->title = 'Create Our Works';
$this->params['breadcrumbs'][] = ['label' => 'Our Works', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="our-works-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
