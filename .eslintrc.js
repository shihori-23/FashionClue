module.exports = {
    root: true,
    env: {
        es6: true,
        "browser": true,
    },
    extends: [
        "eslint:recommended",
        'plugin:prettier/recommended',
        'plugin:vue/recommended',
        'prettier/vue',
    ],
    plugins: ['vue', 'prettier'],
    globals: {
        "Vue": true
    },
    rules: {
        'prettier/prettier': [
            'error',
            {
                singleQuote: true,
                trailingComma: 'es5',
            },
        ],
        "vue/html-indent": ["error", 2],
        'global-require': 0,
        'import/no-unresolved': 0,
        'no-param-reassign': 0,

    },
};
