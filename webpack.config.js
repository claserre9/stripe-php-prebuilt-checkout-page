const path = require('path');
const TerserPlugin = require('terser-webpack-plugin'); // Plugin for minification
const MiniCssExtractPlugin = require('mini-css-extract-plugin'); // Extract CSS in production

module.exports = (env, argv) => {
    const isDevelopment = argv.mode === 'development'; // Determine mode (development or production)

    return {
        // Entry points for JavaScript and CSS
        entry: {
            home: ['./public/assets/js/home.js', './public/assets/css/home.css'], // Home related JS and CSS
            auth: ['./public/assets/js/auth.js'], // Auth related JS (add CSS here if necessary)
        },
        // Output settings
        output: {
            path: path.resolve(__dirname, 'public/dist'), // Output directory
            filename: '[name].bundle.js', // Naming pattern for JS files
        },
        // Loaders for processing files
        module: {
            rules: [
                {
                    test: /\.js$/, // Match JS files
                    exclude: /node_modules/, // Exclude installed libraries
                    use: {
                        loader: 'babel-loader', // Use Babel to transpile code
                        options: {
                            presets: ['@babel/preset-env'], // Transpile modern JavaScript to older versions
                        },
                    },
                },
                {
                    test: /\.css$/, // Match CSS files
                    use: [
                        isDevelopment
                            ? 'style-loader' // Inject styles into DOM for development
                            : MiniCssExtractPlugin.loader, // Extract CSS for production
                        'css-loader', // Process CSS imports
                    ],
                },
            ],
        },
        // Optimization settings
        optimization: {
            minimize: !isDevelopment, // Enable minification in production
            minimizer: [
                new TerserPlugin({
                    terserOptions: {
                        format: {
                            comments: false, // Strip comments in production
                        },
                    },
                    extractComments: false, // Prevent additional LICENSE files
                }),
            ],
        },
        // Plugins for additional functionality
        plugins: [
            new MiniCssExtractPlugin({
                filename: '[name].bundle.css', // Naming pattern for CSS files
            }),
        ],
        // Enable source maps only in development
        devtool: isDevelopment ? 'source-map' : false,
        // Enable Watch Mode only in development
        watch: isDevelopment, // Automatically rebuild when files change in development
        watchOptions: {
            ignored: /node_modules/, // Ignore changes in the node_modules directory
        },
        // Pass down the mode (development or production)
        mode: argv.mode || 'development',
    };
};