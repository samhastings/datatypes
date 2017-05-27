<?php

namespace DataTypes\Filesystem;

class ArticlesDirectory implements DirectoryInterface
{
    /**
     * Returns the full path to the articles directory.
     *
     * @return string
     */
    public function getPath(): string
    {
        return realpath(__DIR__.'/../articles');
    }

    /**
     * Returns the full path to a single article. Does not check its validity.
     *
     * @param string $id
     *
     * @return string
     */
    public function getItemPath(string $id): string
    {
        return $this->getPath().'/'.$id;
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
    public function getItemFilePath(string $id, string $filename): string
    {
        return $this->getItemPath($id).'/'.$filename;
    }

    /**
     * Returns whether an article exists.
     *
     * @param string $id
     *
     * @return bool
     */
    public function isValidItem(string $id): bool
    {
        return is_dir($this->getItemPath($id));
    }

    /**
     * Returns the article schema definition.
     *
     * @return string
     */
    public function getSchema(): string
    {
        return file_get_contents(__DIR__.'/schema/article.json');
    }

    /**
     * Returns an iterator for looping through articles.
     *
     * @return Traversable
     */
    public function getIterator(): \Traversable
    {
        return new \CallbackFilterIterator(new \FilesystemIterator($this->getPath()), function (\SplFileInfo $item) {
            return $item->isDir();
        });
    }
}
