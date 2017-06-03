const Ajv = require('ajv');
const fs = require('fs');

const root = `${__dirname}/../articles`;
const dataFilename = 'data.json';
const contentFilename = 'content.md';
const snippetFilename = 'snippet.sql';

const ajv = new Ajv({
    allErrors: true,
});
const schema = JSON.parse(fs.readFileSync(`${__dirname}/../schema/article.json`), 'utf8');
const validateSchema = ajv.compile(schema);

const excludedFiles = ['.DS_Store', '.gitignore', '.gitkeep'];
const expectedFiles = [dataFilename, contentFilename, snippetFilename];

function validate(id, verbose = false) {
    const dir = `${root}/${id}`;

    if (verbose) {
        console.log(`Validating article “${id}”...`);
    }

    // Check only expected files are present.
    fs.readdir(dir, (error, files) => {
        if (error) {
            throw `Invalid article directory ${id}`;
        }

        files = files.filter(file => excludedFiles.indexOf(file) === -1);

        expectedFiles.forEach(file => {
            if (files.indexOf(file) === -1) {
                throw `${dir}/${file} not found`;
            }
        });

        const unexpectedFiles = files.filter(file => {
            return expectedFiles.indexOf(file) === -1;
        }).map(file => {
            return `${dir}/${file}`;
        });

        if (unexpectedFiles.length > 0) {
            throw `Unexpected files found: ${unexpectedFiles.join(', ')}`;
        }

        if (verbose) {
            console.log('All files present and correct...');
        }
    });

    // Validate the Json file.
    fs.readFile(`${dir}/${dataFilename}`, 'utf8', (error, contents) => {
        const data = JSON.parse(contents);
        const valid = validateSchema(data);

        if (!valid) {
            console.log(validateSchema.errors);
            throw `Schema validation failed`;
        }

        if (data.id !== id) {
            throw `Value for “id” in “${id}/${dataFilename} must be the same as the directory name.`;
        }

        if (verbose) {
            console.log(`${dataFilename} is valid`);
        }
    });

    // There’s not much we can do to validate the content and snippet files
    // other than make sure they actually contain some content.
    fs.readFile(`${dir}/${contentFilename}`, 'utf8', (error, contents) => {
        if (contents.trim().length === 0) {
            throw `${id}/${contentFilename} is empty`;
        }

        if (verbose) {
            console.log(`${contentFilename} is valid`);
        }
    });

    fs.readFile(`${dir}/${snippetFilename}`, 'utf8', (error, contents) => {
        if (contents.trim().length === 0) {
            throw `${id}/${snippetFilename} is empty`;
        }

        if (verbose) {
            console.log(`${snippetFilename} is valid`);
        }
    });
}

if (process.argv[2] === undefined) {
    fs.readdir(root, (error, files) => {
        if (error) {
            throw error;
        }

        files = files.filter(file => excludedFiles.indexOf(file) === -1);
        files.forEach(file => validate(file, false));
    });
} else {
    validate(process.argv[2], true);
}
