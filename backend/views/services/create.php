<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Services */

$this->title = 'Create Services';
$this->params['breadcrumbs'][] = ['label' => 'Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="services-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'model_seo' => $model_seo,
        'model_event' => $model_event,
    ]) ?>

</div>
