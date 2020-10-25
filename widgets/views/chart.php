<?php

use dosamigos\chartjs\ChartJs;
use yii\helpers\Html;

$var = Yii::$app->request->get('year');
$getYear = $var == "year"  ? $var : $var ? (int) $var : (int) date("Y");
$countYears = count($data['years']); ?>

    <h3>График хода строительства</h3>
    <p>На основе данных портала "Добродел".</p>

<?php if ($countYears > 1) : ?>
    <?= Html::a('По годам', $url + ['year'=>'year'], ['class'=> 'btn btn-danger'])?>
    <?php foreach ($data['years'] as $year): ?>
    <?= Html::a($year, $url + ['year'=>$year], ['class'=> 'btn btn-primary'])?>
    <?php
        $dataLabel =  $getYear ?  $data['months'][$getYear] : $data['years'];
        $dataNumber = $getYear ?  $data['dataMonth'][$getYear] :  $data['dataYear'];
        $dataPaceNumber = $getYear ?  $data['paceMonth'][$getYear] :  $data['paceYear'];
        $label  =   "Степень готовности в % ". ($getYear ? $getYear."г." : 'по годам');
        $labelPace  =   "Темп строительства в % ". ($getYear ? $getYear."г." : 'по годам');
    endforeach;
    else:
        $dataLabel = $data['months'][$data['years'][0]];
        $dataNumber = $data['dataMonth'][$data['years'][0]];
        $dataPaceNumber = $data['paceMonth'][$data['years'][0]];
        $label  =   "Степень готовности в % ". $data['years'][0]." г.";
        $labelPace  =   "Темп строительства в % ". $data['years'][0]." г.";;
endif;
?>

<?php
// определение данных
$dataWeatherOne = [
    'labels' => $dataLabel,
    'datasets' => [
        [
            'data' => $dataNumber,
            'label' =>  $label,
            'fill' => false,
            'lineTension' => 0.1,
            'backgroundColor' => "rgba(75,192,192,0.4)",
            'borderColor' => "rgba(75,192,192,1)",
            'borderCapStyle' => 'butt',
            'borderDash' => [],
            'borderDashOffset' => 0.0,
            'borderJoinStyle' => 'miter',
            'pointBorderColor' => "rgba(75,192,192,1)",
            'pointBackgroundColor' => "#fff",
            'pointBorderWidth' => 1,
            'pointHoverRadius' => 5,
            'pointHoverBackgroundColor' => "rgba(75,192,192,1)",
            'pointHoverBorderColor' => "rgba(220,220,220,1)",
            'pointHoverBorderWidth' => 2,
            'pointRadius' => 1,
            'pointHitRadius' => 10,
            'spanGaps' => false,
        ],
        [
            'data' => $dataPaceNumber,
            'label' => $labelPace,
            'fill' => true,
            'lineTension' => 0.1,
            'backgroundColor' => "rgba(255, 234, 0,0.4)",
            'borderColor' => "rgba(255, 234, 0,1)",
            'borderCapStyle' => 'butt',
            'borderDash' => [],
            'borderDashOffset' => 0.0,
            'borderJoinStyle' => 'miter',
            'pointBorderColor' => "rgba(255, 234, 0,1)",
            'pointBackgroundColor' => "#fff",
            'pointBorderWidth' => 1,
            'pointHoverRadius' => 5,
            'pointHoverBackgroundColor' => "rgba(255, 234, 0,1)",
            'pointHoverBorderColor' => "rgba(220,220,220,1)",
            'pointHoverBorderWidth' => 2,
            'pointRadius' => 1,
            'pointHitRadius' => 10,
            'spanGaps' => false,
        ]
    ]
];



// вывод графиков
echo ChartJs::widget([
    'type'  => 'line',
    'data'  => $dataWeatherOne,
    'plugins' =>
        new \yii\web\JsExpression("
        [{
            afterDatasetsDraw: function(chart, easing) {
                var ctx = chart.ctx;
                chart.data.datasets.forEach(function (dataset, i) {
                    var meta = chart.getDatasetMeta(i);
                    if (!meta.hidden) {
                        meta.data.forEach(function(element, index) {
                            // Draw the text in black, with the specified font
                            ctx.fillStyle = 'rgb(0, 0, 0)';

                            var fontSize = 16;
                            var fontStyle = 'normal';
                            var fontFamily = 'Helvetica';
                            ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);

                            // Just naively convert to string for now
                            var dataString = dataset.data[index].toString()+'%';

                            // Make sure alignment settings are correct
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';

                            var padding = 5;
                            var position = element.tooltipPosition();
                            ctx.fillText(dataString, position.x, position.y - (fontSize / 2) - padding);
                        });
                    }
                });
            }
        }]"),

]);


