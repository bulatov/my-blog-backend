<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

use app\repositories\PostRepository;
use app\repositories\CommentaryRepository;

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
    const SCENARIO_CREATE = 'create';
    const SCENARIO_EDIT = 'edit';

    private $posts;
    private $commentaries;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->posts = new PostRepository();
        $this->commentaries = new CommentaryRepository();
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
            [['content', 'post_id'], 'required'],
            [['post_id', 'parent_id'], 'integer'],
            [['content'], 'string', 'max' => 255],
            [
                /**
                 * Validate that Post with id === post_id exists
                 */
                'post_id',
                function($attribute, $params) {
                    if (!$this->posts->isPostExists(['id' => $this->$attribute])) {
                        $this->addError($attribute, "Validation failed on post_id");
                    }
                },
                'on' => 'create'
            ],
            [
                /**
                 * if parent_id is specified
                 * validate that Commentary with id === parent_id exists in Post with id === post_id
                 */
                'parent_id',
                function($attribute, $params) {
                    $isCommentaryExists = $this->commentaries->isCommentaryExists(['id' => $this->$attribute, 'post_id' => $params['post_id']]);
                    // TODO something is wrong here 
                    if ($this->$attribute && !$isCommentaryExists) {
                        $this->addError($attribute, "Validation failed on parent_id");
                    }
                },
                'on' => 'create'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['post_id', 'content', 'parent_id'];
        $scenarios[self::SCENARIO_EDIT] = ['id', 'content'];
        return $scenarios;
    }
}
