<?php

namespace app\modules\commentaries\models;

use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "commentary".
 *
 * @property int $id
 * @property int $user_id
 * @property int $created_at
 * @property int $post_id
 * @property int $parent_id
 * @property string $content
 */
class Commentary extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false,
            ],
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

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
            [['content', 'post_id'], 'required'],
            [['post_id', 'parent_id'], 'integer'],
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
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'post_id' => 'Post ID',
            'parent_id' => 'Parent ID',
            'content' => 'Content',
        ];
    }
}
