<?php

namespace app\components;

use yii\base\Component;
use yii\base\InvalidArgumentException;

class FrontendRouter extends Component
{
    /**
     * @var string the frontend root url
     */
    public $root;

    /**
     * @var array the array of pages on frontend
     */
    public $pages;

    /**
     * Returns root url
     * @return string
     */
    public function getRoot(): string
    {
        return $this->root;
    }

    /**
     * Returns absolute url for given page
     * @param string $page
     * @return string
     * @throws InvalidArgumentException if given page is not specified by configuration
     */
    public function getUrlByPage(string $page): string
    {
        if (empty($page)) {
            return $this->root;
        }

        if (!in_array($page, $this->pages)) {
            throw new InvalidArgumentException();
        }

        return $this->root . '/' . $page;
    }
}
