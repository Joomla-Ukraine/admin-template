"use strict";

function requireAll(r) {
    r.keys().forEach(r);
}

requireAll(require.context('../icons/majesticons', true, /\.svg$/));
