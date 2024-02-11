module.exports = {
    env: {
        node: true,
    },
    extends: [
        "plugin:vue/strongly-recommended",
        "eslint:recommended",
        "@vue/typescript/recommended",
        "prettier",
    ],
    plugins: ["@typescript-eslint", "prettier"],
    rules: {
        // override/add rules settings here, such as:
        "prettier/prettier": "error",
        "vue/no-multiple-template-root": "off"
    },
    ignorePatterns: [ "/*", "!assets/" ]
}