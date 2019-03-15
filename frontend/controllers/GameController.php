<?php
namespace frontend\controllers;

use common\models\Result;
use common\models\Task;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Game controller
 */
class GameController extends FrontendController
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $min = Task::find()->min('id');
        $max = Task::find()->max('id');
        $id = rand($min, $max);

        $model = Task::find()->where(['id' => $id])->active()->one();

        if ($model === null) {
            return $this->redirect(['index']);
        }

        $wordsArray = $model->words;

        $this->shuffleAssoc($wordsArray);

        return $this->render('index', [
            'model' => $model,
            'words' => $wordsArray
        ]);
    }

    /**
     * Random shuffle game words
     * @param $array
     * @return bool
     */
    protected function shuffleAssoc(&$array) {
        $keys = array_keys($array);
        shuffle($keys);
        foreach($keys as $key) {
            $new[$key] = $array[$key];
        }
        $array = $new;
        return true;
    }

    /**
     * @param $id
     * @param $sentence
     * @return string
     */
    public function actionIsCorrectSentence($id, $sentence)
    {
        $model = Task::find()->where(['id' => $id, 'sentence' => $sentence])->active()->one();

        $result = (new \yii\db\Query())
            ->select(['COUNT(id) AS total'])
            ->addSelect(['CONCAT((CEILING(COUNT(lose)*100/COUNT(id))), "%")  AS lose'])
            ->addSelect(['CONCAT((CEILING(COUNT(Win)*100/COUNT(id))), "%") AS win'])
            ->from('result')
            ->where(['user_id' => Yii::$app->user->id])
            ->one();

        $rModel = new Result();
        $rModel->user_id = Yii::$app->user->id;

        if ($model === null) {
            $rModel->lose = Result::IS_LOSE;
            $rModel->save();
            return Json::encode([
                'success' => false,
                'win' => $result['win'],
                'lose' => $result['lose'],
                'total' => $result['total']
            ]);
        }

        $rModel->win = Result::IS_WIN;
        $rModel->save();

        return Json::encode([
            'success' => true,
            'win' => $result['win'],
            'lose' => $result['lose'],
            'total' => $result['total']
        ]);
    }
}
