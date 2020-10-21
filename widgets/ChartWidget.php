<?php


namespace app\widgets;


use app\models\DictHouses;
use yii\base\Widget;

class ChartWidget extends Widget
{
    /** @var DictHouses $model */
    public $model;
    public $url;

    protected $yearStart = 2016;
    public $data;

    public function init()
    {
        $monthsLabelDefault = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];
        $dataYear = [];
        $dataMonth = [];
        $months = [];
        $years =[];
        $paceYear = [];
        $paceMonth = [];
        $yearInt = (int) date('Y');
        for ($y = $this->yearStart; $y <= $yearInt; $y++) {
            if($dataYearMax = $this->model->getMaxNumberYear($y)) {
                if(count($years) < 1) {
                    $paceYear[] = 0;
                }else {
                    $dataPaceYear =  $dataYearMax - $this->model->getMaxNumberYear($y-1);
                    $paceYear[] = $dataPaceYear;
                }
                $dataYear[] = $dataYearMax;
                $years[] = $y;
                for ($m = 0; $m <= 12; $m++) {
                    if($dataYearMonthMax = $this->model->getMaxNumberYearAndMonth($y, $m)) {
                        if(!key_exists($y, $months)) {
                            $countYear = count($years);
                            $result = $countYear -2;
                            $paceMonth[$y][] = $countYear > 1 ? (int) ($dataYearMonthMax -  (int) end($dataMonth[$years[$result]])) : 0;
                        }else {
                            $dataPaceMount =  $dataYearMonthMax - (int) end($dataMonth[$y]);
                            $paceMonth[$y][] = $dataPaceMount;
                        }
                        $dataMonth[$y][] = $dataYearMonthMax;
                        $months[$y][] = $monthsLabelDefault[$m-1];
                    }
                }
            }
        }

        $this->data =  [
            'months' => $months,
            'dataMonth' => $dataMonth,
            'years' => $years,
            'dataYear' => $dataYear,
            'paceYear' => $paceYear,
            'paceMonth' => $paceMonth ];
    }


    public function run()
    {
        return $this->render('chart', ['data' => $this->data, 'url'=> $this->url]);
    }

}