<?php

use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model \common\models\Task */
/* @var $words array */

$this->title = 'Game';


$this->registerJsFile('/scripts/site.js', ['depends' => 'yii\web\JqueryAsset']);
?>

<div class="game-index">

    <div id="alert-container">

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-xs-12">
                <h2>Sentence</h2>

                <div id="sentence" data-id="<?= $model->id ?>">

                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-xs-12">
                <h2>Words</h2>
            </div>

            <?php foreach ($words as $word): ?>
                <div class="col-xs-2">
                    <div class="words btn-default" data-number="<?= $word['number']; ?>" data-word="<?= $word['text']; ?>">
                        <?= $word['text']; ?>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

        <div class="row">

            <div class="col-xs-6 col-sm-1">

                <?= Html::a('Check', [''], ['id' => 'check', 'class' => 'btn btn-success']) ?>

            </div>

            <div class="col-xs-6 col-sm-1">

                <?= Html::a('Следующее задание', ['index'], ['id' => 'next', 'class' => 'btn btn-info']) ?>

            </div>

        </div>

    </div>
</div>
