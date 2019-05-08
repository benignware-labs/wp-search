const path = require('path');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const pkg = require('./package.json');
const name = path.basename(pkg.main, path.extname(pkg.main));

module.exports = {
  mode: process.env.NODE_ENV || 'development',
  context: path.resolve(__dirname),
  entry:  [
    `./features/suggestions/suggestions.js`,
    `./features/suggestions/suggestions.css`
  ],
  output: {
    filename: path.basename(pkg.main),
    auxiliaryComment: pkg.name
  },
  module: {
    rules: [{
      test: /\.js$/,
      // exclude: /(node_modules|bower_components)\/jquery/,
      use: {
        loader: 'babel-loader',
        options: {
          presets: [
            [
              '@babel/preset-env', {}
            ]
          ],
          plugins: [
            "@babel/plugin-transform-spread"
          ]
        }
      }
    }, {
      test: /\.css$/,
      use: [{
        loader: "file-loader",
        options: {
          name: "[name].css",
          emitFile: true
        }
      }, {
        loader: 'extract-loader'
      }, {
        loader: 'css-loader'
      }]
    }]
  },
  plugins: [
    new CopyWebpackPlugin([
      {
        from: path.resolve(__dirname, 'node_modules/jquery-ui-themes/themes'),
        to: path.resolve(__dirname, 'dist/themes')
      },
      /*{
        from: path.resolve(__dirname, 'node_modules/jquery-ui'),
        to: path.resolve(__dirname, 'dist/jquery-ui')
      }*/
    ])
  ]
};
