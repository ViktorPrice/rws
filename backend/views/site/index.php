<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Панель управления';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="admin-default-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Пользователи</span>
                    <span class="info-box-number"><?= $userCount ?></span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-tasks"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Заявки</span>
                    <span class="info-box-number"><?= $requestCount ?></span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-clock-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Просроченные</span>
                    <span class="info-box-number"><?= $overdueCount ?></span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-exclamation-triangle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Аварийные</span>
                    <span class="info-box-number"><?= $emergencyCount ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Последние заявки</h3>
                </div>
                <div class="box-body">
                    <?= GridView::widget([
                        'dataProvider' => $recentRequests,
                        'columns' => [
                            'id',
                            'train_number',
                            'defect_short',
                            'status',
                            'created_at:datetime',
                        ],
                    ]); ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Статистика по статусам</h3>
                </div>
                <div class="box-body">
                    <canvas id="statusChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Подключение Chart.js
$this->registerJsFile('https://cdn.jsdelivr.net/npm/chart.js');
$this->registerJs(<<<JS
    var ctx = document.getElementById('statusChart').getContext('2d');
    var statusChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: $statusLabels,
            datasets: [{
                label: 'Количество заявок',
                data: $statusData,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
JS);
?>