<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_files".
 *
 * @property int $id
 * @property string $created_at
 * @property int $task_id
 * @property string $file_path
 *
 * @property Tasks $task
 */
class TaskFiles extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['task_id', 'file_path'], 'required'],
            [['task_id'], 'integer'],
            [['file_path'], 'string', 'max' => 500],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::class, 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'task_id' => 'Task ID',
            'file_path' => 'File Path',
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::class, ['id' => 'task_id']);
    }

}
