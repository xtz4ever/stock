<?php
namespace frontend\widgets;

use frontend\models\LangTextForSite;
use Yii;
use common\models\PartnerReferalLinks;

class PersonalAreaLink extends \yii\base\Widget
{
    public $error;

    public function init(){

    }

    public function run() {

        $page_text = LangTextForSite::actionTEXT(Yii::$app->controller->action->id);

        $model = new PartnerReferalLinks();

        $link = $model->getPartnerLastLink(Yii::$app->user->identity->getId());

        return $this->render('personal-area-link/view', [
            'page_text' => $page_text,
            'model' => $model,
            'link' => $link,
        ]);
    }
}