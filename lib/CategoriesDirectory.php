<?php

namespace DataTypes\Filesystem;

class CategoriesDirectory implements DirectoryInterface
{
    /**
     * Returns the full path to the categories directory.
     *
     * @return string
     */
    public function getPath(): string
    {
        return realpath(__DIR__.'/../categories');
    }

    /**
     * Returns the full path to a single category. Does not check its validity.
     *
     * @param string $id
     *
     * @return string
     */
    public function getItemPath(string $id): string
    {
        return $this->getPath().'/'.$id.'.json';
    }

    /**
     * As categories use a flat directory structure, this method throws an
     * exception on call.
     *
     * @param string $id
     * @param string $filename
     *
     * @return string
     */
    public function getItemFilePath(string $id, string $filename = null): string
    {
        if (null === $filename) {
            return $this->getItemPath($id);
        }

        throw new \RuntimeException('Category file paths are not used.');
    }

    /**
     * Returns whether a category exists.
     *
     * @param string $id
     *
     * @return bool
     */
    public function isValidItem(string $id): bool
    {
        return is_readable($this->getItemPath($id));
    }

    /**
     * Returns the category schema definition.
     *
     * @return string
     */
    public function getSchema(): string
    {
        return file_get_contents(__DIR__.'/schema/category.json');
    }

    /**
     * Returns an iterator for looping through categories.
     *
     * @return Traversable
     */
    public function getIterator(): \Traversable
    {
        return new \CallbackFilterIterator(new \FilesystemIterator($this->getPath()), function (\SplFileInfo $item) {
            return $item->isFile() && 'json' === $item->getExtension();
        });
    }
}
