const mix = require('laravel-mix');
const { VueLoaderPlugin } = require('vue-loader');
const webpack = require('webpack');

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css')
    .webpackConfig({
        plugins: [
            new VueLoaderPlugin(),
            new webpack.DefinePlugin({
                '__VUE_OPTIONS_API__': JSON.stringify(true),
                '__VUE_PROD_DEVTOOLS__': JSON.stringify(false),
                '__VUE_PROD_HYDRATION_MISMATCH_DETAILS__': JSON.stringify(false),
            }),
        ],
            resolve: {
                extensions: ['.wasm', '.mjs', '.js', '.jsx', '.json', '.vue']

        },
        module: {
            rules: [
                {
                    test: /\.vue$/,
                    loader: 'vue-loader',
                },
            ],
        },
    });

mix.version();
