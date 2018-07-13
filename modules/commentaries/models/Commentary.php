<?php

namespace app\modules\commentaries\models;

/**
 * This is the model class for table "commentary".
 *
 * @property int $id
 * @property string $content
 * @property int $user_id
 * @property string $created_at
 * @property int $position
 */
class Commentary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'commentary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content', 'user_id', 'created_at', 'position'], 'required'],
            [['user_id', 'position'], 'integer'],
            [['created_at'], 'safe'],
            [['content'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'position' => 'Position',
        ];
    }
}
