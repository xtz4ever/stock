<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SeoPage */


$this->title = 'Update Seo Page: ' . $page_name;
$this->params['breadcrumbs'][] = ['label' => 'Seo Pages', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $page_name, 'url' => ['view', 'id' => $page_name]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="seo-page-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'langs' => $langs,
        'page_name' => $page_name,

    ]) ?>

</div>
