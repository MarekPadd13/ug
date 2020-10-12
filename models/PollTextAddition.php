<?php

namespace app\models;


use yii\base\Model;
use Yii;
use app\modules\sending\models\SendingDeliveryStatus;
class PollTextAddition extends Model
{
    public $answerId;
    public $textAddition;
    public $dateTimePoll;


    public function rules()
    {
        return [
            [['answerId', 'textAddition'], 'required'],
            ['dateTimePoll', 'safe'],
        ];
    }

    public function attributeLabels()
    {

        return [
            'textAddition'=> 'Выбранный Вами вариант требует уточнения:',
        ];
    }

    public function save($answerId, $hash)
    {
        $model = SendingDeliveryStatus::find()->andWhere(['hash'=>$hash])->one();
        $model->poll_answer_id = $answerId;
        $model->date_time_poll_answer = date('Y-m-d H:i:s');
        $model->status_id = SendingDeliveryStatus::STATUS_HAS_POLL;
        $model->poll_text = $this->textAddition;

        if($model->save())
        {
            return true;
        }else{
            throw new \Exception('ошибка при сохранении'. print_r($model->errors));
        }



        return true;
    }


}