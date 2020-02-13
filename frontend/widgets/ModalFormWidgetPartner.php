<?php
namespace frontend\widgets;

use frontend\models\LangTextForSite;
use Yii;
use common\models\UserWallets;
use common\models\User;
use common\models\PartnerUnpaidAmount;
use common\models\PartnerPaymentsList;

class ModalFormWidgetPartner extends \yii\base\Widget
{
    public $error;

    public function init(){}

    public function run() {
        $page_text = LangTextForSite::actionTEXT(Yii::$app->controller->action->id);


        $model = new PartnerPaymentsList();

        $model_user_wallets = new UserWallets();

        $model_user = new User();


        // Одобренные невыплаченные комиссии.
        $unpaid_amount_model = new PartnerUnpaidAmount();
        $unpaid_amount = $unpaid_amount_model->getPartnerUnpaidAmount(Yii::$app->user->identity->getId());
        $unpaid_amount = $unpaid_amount["amount"];
//        Yii::$app->user->identity->getId()




        return $this->render('partner-modal/view', [
            'page_text' => $page_text,
            'model' => $model,
            'unpaid_amount' => $unpaid_amount,
        ]);
    }
}