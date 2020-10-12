<?php

namespace app\models;


class Stream extends \yii\db\ActiveRecord
{
    const ALL_JK = [
        1 => 'ЖК Видный город',
        2 => 'ЖК Опалиха О3',
        3 => 'ЖК Солнечная система',
        4 => 'ЖК Митино О2',
        5 => 'ЖК Лайково',
        6 => 'ЖК Лесобережный',
    ];


    public static function tableName()
    {
        return 'stream';
    }

    public function rules()
    {
        return [
            [['cameraName', 'bodyStream', 'jk_id'], 'required'],
            [['cameraName', 'bodyStream'], 'string'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'cameraName' => 'Название камеры',
            'bodyStream' => 'Ссылка на поток видео',
            'jk_id' => 'Название ЖК',
        ];
    }
}