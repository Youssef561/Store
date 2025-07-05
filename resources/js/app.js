import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


import $ from 'jquery';
window.$ = $;
window.jQuery = $;  // Needed for some plugins

// Import your cart.js
import './cart';



var channel = Echo.private(`App.Models.User.${userID}`);
channel.notification(function(data) {
    console.log(data);
    alert(data.body);
});
