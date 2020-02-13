<?php
namespace frontend\widgets;

use frontend\models\LangTextForSite;
use Yii;
use common\models\AccountsNotAvailableIndex;
class ModalFormWidget extends \yii\base\Widget
{
    public $error;

    public function init(){}

    public function run() {
        $page_text = LangTextForSite::actionTEXT(Yii::$app->controller->action->id);
        $model = new AccountsNotAvailableIndex();




        return $this->render('modal/view', [
            'page_text' => $page_text,
            'model' => $model,
        ]);
    }
}