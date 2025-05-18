import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


import $ from 'jquery';
window.$ = $;
window.jQuery = $;  // Needed for some plugins

// Import your cart.js
import './cart';
