<?php
use \yii\helpers\Html;

?>




<?php if (Yii::$app->language == 'en-EN') { ?>

    <ul class="menu_list" >
        <li <?= Yii::$app->controller->action->id == 'profile-provider' ? 'class="active_item"' : ""; ?> ><?=Html::a('My profile','profile-provider');?></li>
        <li <?= Yii::$app->controller->action->id == 'personal-provider' ? 'class="active_item"' : ""; ?>  ><?=Html::a('Statistics','personal-provider');?></li>
        <li style="display: none" <?= Yii::$app->controller->action->id == 'personal-area-balance' ? 'class="active_item"' : ""; ?>  ><?=Html::a('Balance','personal-area-balance');?></li>
        <li <?= Yii::$app->controller->action->id == 'personal-provider-payments' ? 'class="active_item"' : ""; ?>  ><?=Html::a('Payments','personal-provider-payments');?></li>
        <li><?=Html::a('Exit','/affiliateprogram/logout');?></li>
    </ul>

<?php } else { ?>

    <ul class="menu_list" id="menu_list">
        <li <?= Yii::$app->controller->action->id == 'profile-provider' ? 'class="active_item"' : ""; ?> ><?=Html::a('Мой профиль','profile-provider');?></li>
        <li <?= Yii::$app->controller->action->id == 'personal-provider' ? 'class="active_item"' : ""; ?>  ><?=Html::a('Статистика','personal-provider');?></li>
        <li style="display: none" <?= Yii::$app->controller->action->id == 'personal-area-balance' ? 'class="active_item"' : ""; ?>  ><?=Html::a('Баланс','personal-area-balance');?></li>
        <li <?= Yii::$app->controller->action->id == 'personal-provider-payments' ? 'class="active_item"' : ""; ?>  ><?=Html::a('Выплаты','personal-provider-payments');?></li>
        <li><?=Html::a('Выход','/affiliateprogram/logout');?></li>

    </ul>

<?php } ?>
