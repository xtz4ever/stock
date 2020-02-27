<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Translates */

$this->title = 'Create Translates';
$this->params['breadcrumbs'][] = ['label' => 'Translates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="translates-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
