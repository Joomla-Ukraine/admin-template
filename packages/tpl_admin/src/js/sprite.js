"use strict";

function requireAll(r) {
    r.keys().forEach(r);
}

//requireAll(require.context('../icons/icons', true, /\.svg$/));
requireAll(require.context('../icons/majesticons', true, /\.svg$/));
//requireAll(require.context('../icons/carbon', true, /\.svg$/));