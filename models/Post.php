<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

use app\models\User;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $user_id
 * @property int $created_at
 * @property string $title
 * @property string $content
 *
 * @property Commentary[] $commentaries
 */
class Post extends ActiveRecord
{
    const SCENARIO_WITH_COMMENTARIES = 'withCommentaries';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

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
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['title', 'content'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function fields()
    {
        $fields = parent::fields();

        if ($this->scenario === self::SCENARIO_WITH_COMMENTARIES) {
            $fields[] = 'commentaries';
        }

        $fields['user_name'] = function () {
            return User::getUsernameById($this->user_id);
        };

        unset($fields['user_id']);

        return $fields;
    }

    /**
     * Returns all commentaries for related post
     * @return ActiveQuery
     */
    public function getCommentaries():ActiveQuery
    {
        return $this->hasMany(Commentary::className(), ['post_id' => 'id']);
    }
}
