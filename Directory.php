<?php

namespace DataTypes\Filesystem;

class Directory implements \IteratorAggregate
{
    /**
     * Returns the full path to the articles directory.
     *
     * @return string
     */
    public function getPath()
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
    public function getArticlePath(string $id): string
    {
        return $this->getPath().DIRECTORY_SEPARATOR.$id;
    }

    /**
     * Returns the full path to a file residing in an article’s directory. Does
     * not check its validity.
     *
     * @param string $id
     * @param string $filename
     *
     * @return string
     */
    public function getArticleFilePath(string $id, string $filename): string
    {
        return $this->getArticlePath($id).DIRECTORY_SEPARATOR.$filename;
    }

    /**
     * Returns whether an article exists.
     *
     * @param string $id
     *
     * @return bool
     */
    public function isValidArticle(string $id): bool
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

    public function getIterator()
    {
        return new \CallbackFilterIterator(new \FilesystemIterator($this->getPath()), function (\SplFileInfo $item) {
            return $item->isDir();
        });
    }
}
