<?php

namespace console\controllers;

use common\models\Task;
use common\models\Word;
use Yii;
use yii\console\Controller;

class TaskController extends Controller
{
    public function actionInit()
    {
        $tasks = [
            "Шла Саша по шоссе",
            "Такая-сякая сбежала из дворца",
            "Ну-с, так вот что!",
            "Кто-то счастье ждет, кто-то в сказку верит",
            "У старинушки три сына: старший — умный был детина, средний сын и так и сяк, младший — вовсе был дурак",
            "Два на два будет пять?"
        ];

        foreach ($tasks as $task) {
            $words = Task::generateWords($task);

            if (count($words) > 3) {
                $model = new Task();
                $model->sentence = $task;
                $model->save();

                $taskId = $model->id;
                foreach ($words as $word) {
                    $wModel = new Word();
                    $wModel->task_id = $taskId;
                    $wModel->generateNumber();
                    $wModel->text = $word;
                    try {
                        $wModel->save();
                    } catch (\Exception $e) {}

                    unset($wModel);
                }

                unset($model);
            }
        }
    }
}