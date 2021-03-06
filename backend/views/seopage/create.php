<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SeoPage */

$this->title = 'Create Seo Page';
$this->params['breadcrumbs'][] = ['label' => 'Seo Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seo-page-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'langs' => $langs,
    ]) ?>

</div>
