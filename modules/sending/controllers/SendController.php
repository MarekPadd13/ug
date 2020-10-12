<?php

namespace app\modules\sending\controllers;

use app\components\DateTimeToChpu;
use app\models\Diploma;
use app\models\Invitation;
use app\models\Olimpic;
use app\models\PersonalPresenceAttempt;
use app\modules\sending\models\CreateCategory;
use app\modules\sending\models\DictSendingTemplate;
use app\modules\sending\models\DictSendingUserCategory;
use app\modules\sending\models\Sending;
use app\modules\sending\models\SendingDeliveryStatus;
use app\modules\sending\models\SendingUserCategory;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\web\Controller;
use Yii;
use yii\web\HttpException;
use app\components\TbsWrapper;
use yii\helpers\Html;


/**
 * Default controller for the `sending` module
 */
class SendController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */

    public $salt = 'XwvJjJXv';

    public function actionStartSending($sendId)
    {
        set_time_limit(300);

        $model = $this->findModel($sendId);

        $templateId = DictSendingTemplate::find()->andWhere(['id' => $model->template_id])->one();

        if (!$templateId) {
            throw new \Exception('не найден шаблон письма');
        }


        if ($model->template->check_status == DictSendingTemplate::CHECK) {
            $model->status_id = Sending::CONFIRM;
        } else {
            return '#alert Рассылка не может быть запущена, пока не проверен шаблон письма!';

        }


        if ($model->save()) {

//            if (!SendingDeliveryStatus::find()->andWhere(['sending_id' => $model->id])->exists()) {
                $recipients = SendingUserCategory::find()
                    ->andWhere(['category_id' => $model->sending_category_id])
                    ->all();

                foreach ($recipients as $key => $user) {

                    if(SendingDeliveryStatus::find()
                        ->andWhere(['sending_id'=>$model->id])
                        ->andWhere(['user_id'=>$user->user_id])
                        ->exists())
                    {
                        continue;
                    }

                    $hashMsg = \md5($this->salt
                        . ' '
                        . $model->name
                        . ' '
                        . $user->user_id);

                    //@TODO различные условия для отправки писем, в зависимости от шаблона

                    $newDeliveryStatus = new SendingDeliveryStatus();
                    $newDeliveryStatus->hash = $hashMsg;
                    $newDeliveryStatus->sending_id = $model->id;
                    $newDeliveryStatus->user_id = $user->user_id;
                    if ($user->user->email !== null) {
                        $newDeliveryStatus->status_id = SendingDeliveryStatus::STATUS_SEND;
                    } else {
                        $newDeliveryStatus->status_id = SendingDeliveryStatus::STATUS_NO_EMAIL;
                    }
                    if (!$newDeliveryStatus->save()) {
                        throw new \Exception('Ошибка в коде при сохранении в журнал отправлений. Итерация №'
                            . $key);
                    }


                    $emailBodyText = Sending::getLetter($sendId, $user->user_id, Sending::TYPE_TEXT, $model->value, $hashMsg);
                    $emailBodyHtml = Sending::getLetter($sendId, $user->user_id, Sending::TYPE_HTML, $model->value, $hashMsg);

                    if ($user->user->email !== null && $model->kind_sending_id == Sending::VIA_EMAIL_WA) {
                        Yii::$app->mailer->compose()
                            ->setFrom(['cpk@mpgu.edu'=> 'Инициативная группа ЖК "Видный город'])
                            ->setTo($user->user->email)
                            ->setSubject($model->name)
                            ->setTextBody($emailBodyText)
                            ->setHtmlBody($emailBodyHtml)
                            ->send();

                    }
                }


                $model->updateAttributes(['status_id' => Sending::FINISH_SENDING]);

//            }


            return null;

        }
    }

    public function actionIndex()
    {

        if (Yii::$app->user->can('admin_faculty')) {
            $model = Sending::find()
                ->orderBy(['status_id' => SORT_ASC, 'deadline' => SORT_ASC]);
        } else {
            $model = Sending::find()
                ->andWhere(['user_id' => Yii::$app->user->id])
                ->orderBy(['status_id' => SORT_ASC, 'deadline' => SORT_ASC]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => false,
        ]);


        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $dictTemplate = DictSendingTemplate::find()->select('name')->indexBy('id')->column();
        $dictUserCategory = DictSendingUserCategory::find()->select('name')->indexBy('id')->column();

        $model = new Sending();
        $model->user_id = Yii::$app->user->id;
        $model->status_id = Sending::WEITING_MODERATION;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return null;
        }

        return $this->renderAjax('_form',
            [
                'model' => $model,
                'dictTemplate' => $dictTemplate,
                'dictUserCategory' => $dictUserCategory,
            ]);

    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->status_id == Sending::FINISH_SENDING) {
            Yii::$app->session->setFlash('error', 'Нельзя редактировать рассылку со статусом "Рассылка завершена"');
            return $this->redirect('send');
        }
        $dictTemplate = DictSendingTemplate::find()->select('name')->indexBy('id')->column();
        $dictUserCategory = DictSendingUserCategory::find()->select('name')->indexBy('id')->column();

        $model->status_id = Sending::WEITING_MODERATION;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return null;
        }

        return $this->renderAjax('_form', [
            'model' => $model,
            'dictTemplate' => $dictTemplate,
            'dictUserCategory' => $dictUserCategory,
        ]);


    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->status_id == Sending::FINISH_SENDING) {
            Yii::$app->session->setFlash('error', 'Нельзя удалять рассылку со статусом "Рассылка завершена"');
            return $this->redirect('send');
        }

        $this->findModel($id)->delete();
    }

    protected function findModel($id)
    {
        $model = Sending::find()->andWhere(['id' => $id])->one();

        return $model;
    }
}
