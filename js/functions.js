'use strict';

const fs = require('fs');
const path = require('path');
const querystring = require('querystring');

module.exports = (config = {}) => {

  config = Object.assign({
    add_version: true,
  }, config);

  return {
    asset: (asset_path) => {
      if (!config.path) {
        return asset_path;
      }
      const absolute_path = path.join(config.path, asset_path);
      if (fs.existsSync(absolute_path) && config.add_version) {
        const stats = fs.statSync(absolute_path);
        const filemtime = Math.floor(stats.mtimeMs / 1000);
        const query_string = querystring.stringify({
          v: filemtime,
        });
        asset_path += `?${query_string}`;
      }
      return asset_path;
    }
  }

}
