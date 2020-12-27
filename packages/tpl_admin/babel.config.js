"use strict";

module.exports = {
    presets: [
        [
            "@babel/preset-env",
            {
                "modules": false,
                "targets": {
                    "browsers": [
                        "cover 99.5%"
                    ]
                }
            }
        ]
    ]
};