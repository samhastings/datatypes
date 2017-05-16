<?php

namespace DataTypes;

class Data
{
    /**
     * Returns the full path to the articles directory.
     *
     * @return string
     */
    public function getArticlesPath()
    {
        return realpath(__DIR__.'/datatypes');
    }

    /**
     * Returns the full path to a single article. Does not check its validity.
     *
     * @param string $id
     *
     * @return string
     */
    public function getArticlePath($id)
    {
        return $this->getArticlesPath().DIRECTORY_SEPARATOR.$id;
    }

    /**
     * Returns whether an article exists.
     *
     * @param string $id
     *
     * @return bool
     */
    public function isValidArticle($id)
    {
        return is_dir($this->getArticlePath($id));
    }

    /**
     * Returns the article schema definition.
     *
     * @return string
     */
    public function getSchema()
    {
        return file_get_contents(__DIR__.'/schema/article.json');
    }
}
