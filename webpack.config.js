const Encore = require('@symfony/webpack-encore');

Encore
  .setOutputPath('web/dist/')
  .setPublicPath('/dist')
  .addEntry('react', './js_src/index.jsx')
  .enableBuildNotifications()
  .enableReactPreset()
  .enableSassLoader()
  .enableSourceMaps(!Encore.isProduction())
  .cleanupOutputBeforeBuild()
  .enableVersioning();

module.exports = Encore.getWebpackConfig();
