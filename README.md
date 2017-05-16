# DataTypes data

This repository contains all of the data which powers the [DataTypes.io](https://datatypes.io) website.

## Validation

We’ve also included some validation scripts to ensure the integrity of submitted data. Please ensure your contributions pass without errors before submitting a pull request.

The scripts:

- Verify the presence of `data.json` and `article.md` in the article directory.
- Validate the contents of `data.json` based on a Json schema.
- Check that `article.md` is not empty.
- Ensures the `id` field in the Json file corresponds with the article’s directory name.

The scripts run on Node.

### Usage

The article validation script can validate either a specific article, or the whole list.

    ```bash
    $ node validate/article.js
    $ node validate/article.js article-id
    ```
