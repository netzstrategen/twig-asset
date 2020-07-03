'use strict';

const fs = require('fs');
const path = require('path');
const querystring = require('querystring');

module.exports = (config = {}) => {

  config = Object.assign({
    add_version: true,
    asset_path_document_root: '',
  }, config);

  return {
    asset: (asset_path) => {
      const absolute_path = path.join(config.asset_path_document_root, asset_path);
      if (config.add_version && fs.existsSync(absolute_path)) {
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
