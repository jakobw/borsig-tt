const ExtractTextPlugin = require('extract-text-webpack-plugin');

const extractSass = new ExtractTextPlugin({
  filename: 'css/styles.css',
  disable: false
});

module.exports = {
  entry: './js/index.js',

  output: {
    filename: 'bundle.js'
  },

  module: {
    rules: [
      {
        test: /\.scss$/,
        use: ExtractTextPlugin.extract({
          use: [ 'css-loader', 'sass-loader' ]
        })
      }
    ]
  },

  plugins: [
    extractSass
  ]
}
