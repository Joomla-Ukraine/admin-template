"use strict";

function requireAll(r) {
    r.keys().forEach(r);
}

requireAll(require.context('../icons/theme', true, /\.svg$/));
requireAll(require.context('../icons/uikit', true, /\.svg$/));