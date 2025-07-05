import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


import Echo from 'laravel-echo'

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '7db7f7c647e52c74e3ec',
    cluster: 'eu',
    forceTLS: true
});

// var channel = Echo.channel('my-channel');
// channel.listen('.my-event', function(data) {
//     alert(JSON.stringify(data));
// });
