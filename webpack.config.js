var Encore = require('@symfony/webpack-encore');
const path = require('path');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', './assets/js/app.js')
    .addEntry('pages/login', './assets/css/pages/login.scss')
    .addEntry('pages/entities/accounts', './assets/js/pages/entities/accounts.js')
    .addEntry('pages/entities/currencies', './assets/js/pages/entities/currencies.js')
    .addEntry('pages/entities/owners', './assets/js/pages/entities/owners.js')

    /*
     * Copy js dependencies libraries
     */
    .addEntry('vendors/css/fontawesome', './node_modules/@fortawesome/fontawesome-free/css/all.min.css')
    .addEntry('vendors/css/sb-admin-2', './node_modules/startbootstrap-sb-admin-2/css/sb-admin-2.min.css')
    .addEntry('vendors/css/datatables', './node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css')
    .addEntry('vendors/css/toastr', './node_modules/toastr/build/toastr.min.css')
    .addEntry('vendors/js/jquery.easing', './node_modules/jquery.easing/jquery.easing.min.js')
    .addEntry('vendors/js/sb-admin-2', './node_modules/startbootstrap-sb-admin-2/js/sb-admin-2.min.js')
    .addEntry('vendors/js/datatables', './node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })

    // enables Sass/SCSS support
    .enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()

    // Static images
    .copyFiles({
        from: './assets/images',
        to: 'images/[path][name].[ext]',

        // only copy files matching this pattern
        //pattern: /\.(png|jpg|jpeg)$/
    })

// uncomment if you use API Platform Admin (composer req api-admin)
//.enableReactPreset()
//.addEntry('admin', './assets/js/admin.js')
;

const config = Encore.getWebpackConfig();
config.resolve.alias = {
    ...config.resolve.alias,
    '@': path.resolve(__dirname, 'assets'),
    '@css': path.resolve(__dirname, 'assets/css'),
    '@js': path.resolve(__dirname, 'assets/js'),
};
module.exports = config;
