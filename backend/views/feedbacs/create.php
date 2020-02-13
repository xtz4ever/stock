<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Feedbacs */

$this->title = 'Create Feedbacs';
$this->params['breadcrumbs'][] = ['label' => 'Feedbacs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feedbacs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
