const path = require('path');
const Encore = require('@symfony/webpack-encore');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/styles/app.css')
    .enableSassLoader() // si vous utilisez SCSS
    .enablePostCssLoader() // pour Tailwind CSS
    .enableSourceMaps(!Encore.isProduction())
    .addPlugin(new CssMinimizerPlugin()) // Ajouter le plugin CssMinimizer
    .enableSingleRuntimeChunk()
;

module.exports = Encore.getWebpackConfig();
