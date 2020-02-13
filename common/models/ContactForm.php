<?php

namespace common\models;

use Yii;
use yii\base\Model;
use himiklab\yii2\recaptcha\ReCaptchaValidator;
/**
 * This is the model class for table "feedbacs".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $subject
 * @property string $telephone
 * @property integer $status

 */
class ContactForm extends \yii\db\ActiveRecord
{


    public $verifyCode;

    public static function tableName()
    {
        return 'contact_form';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject'], 'required'],
            [['telephone', ], 'string'],
            // email has to be a valid email address
            ['email', 'email'],
            [['verifyCode'], ReCaptchaValidator::className(), 'secret' => Yii::$app->params['reCaptcha_secret'], 'when' => function($model){ return !$model->getErrors() && Yii::$app->request->isAjax === false /*!Yii::$app->request->isAjax*/ /* !Yii::$app->request->post('ajax')*/; },]

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        if (Yii::$app->language == 'ru-RU') {
            return [
                'id' => 'ID',
                'name' => 'Имя',
                'email' => 'Эл. адрес:',
                'date' => 'Date',
                'subject' => 'Сообщение',
                'status' => 'Status',
                'lang' => 'lang',
                'verifyCode' => ''
            ];
        } else {
            return [
                'id' => 'ID',
                'name' => 'Name',
                'email' => 'Email',
                'date' => 'Date',
                'subject' => 'Message',
                'status' => 'Status',
                'lang' => 'lang',
                'verifyCode' => ''
            ];
        }
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }

    static function sendEmailMy($case, $name = NULL , $email = NULL, $quantity = NULL , $form_name = NULL , $subject_message = NULL, $telephone = NULL)
    {

        switch ($case) {

            /*Отправляем Сообщение в поддержку*/
            case 'AccountsNotAvailableIndex':

                $message = '<h1>' . 'Запрос на покупку аккаунтов с сайта vavilovdesign' . '</h1> <p>
                <h3 style="text-align: left;" >Требуемые аккаунты : ' . $name . '</h3></p>' . "\n" . "\n" .
                    '<p><h3 style="text-align: left;">Требуемое кол-во аккаунтов  : ' . $quantity . '</h3></p>' .
                    '<p><h3 style="text-align: left;">Эл. адрес : ' . $email . '</h3></p>' .
                    '<p><h3 style="text-align: left;">форма : ' . $form_name . '</h3></p>';


                $subject = 'Запрос на покупку аккаунтов с сайта vavilovdesign';

                break;

            case 'Feedbacs':

                $message = '<h1>' . 'Новый отзыв на сайте vavilovdesign' . '</h1> <p>
                    <h3 style="text-align: left;" >От : ' . $name . '</h3></p>' . "\n" . "\n" .
                    '<p><h3 style="text-align: left;">Эл. адрес : ' . $email . '</h3></p>'. "\n" . "\n" .
                    '<p><h3 style="text-align: left;">Отзыв : ' . $subject_message . '</h3></p>';

                $subject = 'Новый отзыв на сайте vavilovdesign';

                break;

            case 'Createcontacts':

                $message = '<h1>' . 'Новый вопрос на сайте vavilovdesign' . '</h1> <p>
                    <h3 style="text-align: left;" >От : ' . $name . '</h3></p>' . "\n" . "\n" .
                    '<p><h3 style="text-align: left;">Эл. адрес : ' . $email . '</h3></p>'. "\n" . "\n" .
                    '<p><h3 style="text-align: left;">Телефон : ' . $telephone . '</h3></p>'. "\n" . "\n" .
                    '<p><h3 style="text-align: left;">Сообщение : ' . $subject_message. '</h3></p>'. "\n" . "\n" .
                    '<p><h3 style="text-align: left;">Дата : ' . date('d-m-Y') . '</h3></p>'. "\n" . "\n" ;

                $subject = 'Новый вопрос на сайте vavilovdesign';

                break;


        }


             Yii::$app->mailer->compose()
            ->setFrom([Yii::$app->params['stockEmail'] => 'vavilovdesign'])
            ->setTo(Yii::$app->params['supportEmail'])
//            ->setTo('xtz4ever@yandex.ua')
            ->setSubject($subject)
            ->setTextBody($message)
            ->setHtmlBody($message)
            ->send();


    }

    public static function getNewContact(){
        $new = ContactForm::find()->where(['status' => 0])->asArray()->all();

        if ($new){
            return count($new);
        }else{
            return 0;
        }
    }
    public static function updateStatus($id,$status){
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("UPDATE `contact_form` SET `status`= :status  WHERE id = :id", [':status' => (int)$status,':id' => (int)$id]);
        $command->query();
    }
}
