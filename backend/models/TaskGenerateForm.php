<?php
namespace backend\models;

use common\models\Task;
use common\models\Word;
use Yii;
use yii\base\Model;

/**
 * TaskGenerate form
 */
class TaskGenerateForm extends Model
{
    public $text;
    private $_id;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            ['text', 'required'],
            ['text', 'string'],
            ['text', 'match', 'pattern' => '/^[^a-zа-я\?\; \.\!\:\-]+$/iu'],
        ];
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setId($id)
    {
        $this->_id = $id;
    }

    public function save()
    {
        $sentences = Task::generateSentences($this->text);

        foreach ($sentences as $sentence) {
            $words = Task::generateWords($sentence);

            if (count($words) > 3) {
                $tModel = new Task();
                $tModel->sentence = $sentence;
                $tModel->save();

                $taskId = $tModel->id;
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

                unset($tModel);
            }
        }
        return true;
    }
}
