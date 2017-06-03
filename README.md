# DataTypes data

This repository contains all of the data which powers the [DataTypes.io](https://datatypes.io) website.

## Creating an article

The [template](template) directory contains blank files you can use to create a new article.

## Validation

We’ve included a validation script to ensure the integrity of submitted data. Please ensure your contributions pass without errors before submitting a pull request.

The script:

- Verifies the presence of `data.json`, `content.md` and `snippet.sql` in the article directory.
- Validates the contents of `data.json` based on a [Json schema](schema/article.json).
- Checks that `content.md` and `snippet.sql` are not empty.
- Ensures the `id` field in the Json file corresponds with the article’s directory name.

### Usage

The article validation script can validate either a specific article, or the whole list. Ensure you have [Node.js](https://nodejs.org/) installed.

```bash
$ node validate/article.js
$ node validate/article.js article-id
```
