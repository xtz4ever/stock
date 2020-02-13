<?php
use \yii\helpers\Html;

?>




<?php if (Yii::$app->language == 'en-EN') { ?>

    <ul class="menu_list" >
        <li <?= Yii::$app->controller->action->id == 'personal-area' ? 'class="active_item"' : ""; ?> ><?=Html::a('My profile','personal-area');?></li>
        <li <?= Yii::$app->controller->action->id == 'personal-area-statistic' ? 'class="active_item"' : ""; ?>  ><?=Html::a('Statistics','personal-area-statistic');?></li>
        <li <?= Yii::$app->controller->action->id == 'personal-area-balance' ? 'class="active_item"' : ""; ?>  ><?=Html::a('Balance','personal-area-balance');?></li>
        <li <?= Yii::$app->controller->action->id == 'personal-area-payments' ? 'class="active_item"' : ""; ?>  ><?=Html::a('Payments','personal-area-payments');?></li>
        <li <?= Yii::$app->controller->action->id == 'personal-area-promotional-materials' ? 'class="active_item"' : ""; ?>  ><?=Html::a('Promotional materials','personal-area-promotional-materials');?></li>
        <li><?=Html::a('Exit','/affiliateprogram/logout');?></li>
    </ul>

<?php } else { ?>

    <ul class="menu_list" id="menu_list">
        <li <?= Yii::$app->controller->action->id == 'personal-area' ? 'class="active_item"' : ""; ?> ><?=Html::a('Мой профиль','personal-area');?></li>
        <li <?= Yii::$app->controller->action->id == 'personal-area-statistic' ? 'class="active_item"' : ""; ?>  ><?=Html::a('Статистика','personal-area-statistic');?></li>
        <li <?= Yii::$app->controller->action->id == 'personal-area-balance' ? 'class="active_item"' : ""; ?>  ><?=Html::a('Баланс','personal-area-balance');?></li>
        <li <?= Yii::$app->controller->action->id == 'personal-area-payments' ? 'class="active_item"' : ""; ?>  ><?=Html::a('Выплаты','personal-area-payments');?></li>
        <li <?= Yii::$app->controller->action->id == 'personal-area-promotional-materials' ? 'class="active_item"' : ""; ?>  ><?=Html::a('Рекламные материалы','personal-area-promotional-materials');?></li>
        <li><?=Html::a('Выход','/affiliateprogram/logout');?></li>

    </ul>

<?php } ?>
