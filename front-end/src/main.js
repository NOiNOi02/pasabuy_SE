import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import './assets/css/tailwind.css'  
import api from './api'
import Echo from 'laravel-echo';
import VueSimpleAlert from 'vue-simple-alert'



window.Pusher = require('pusher-js');
window.Echo = new Echo({
    broadcaster: "pusher",
    cluster: 'ap1',
    encrypted: true,
    key: '410753cda4969a0b8071',
    authorizer: (channel) => {
        return {
            authorize: (socketId, callback) => {
                api.post('/api/broadcasting/auth', {
                    socket_id: socketId,
                    channel_name: channel.name
                })
                .then(response => {
                    callback(false, response.data);
                })
                .catch(error => {
                    callback(true, error);
                });
            }
        };
    },
})

api.interceptors.response.use(
    function(response) {
        // Call was successful, don't do anything special.
        return response;
    },
    function (error) {
    switch (error.response.status) {
        case 401: // Not logged in
            VueSimpleAlert.alert("Session expired, Please Log in again","Session Expired","warning")
            api.post('api/logout').then(()=>{
                sessionStorage.clear();
                window.location.reload();

            })
            break;
        case 419: // Session expired
            VueSimpleAlert.alert("Session expired, Please Log in again","Session Expired","warning")
            api.post('api/logout').then(()=>{
                sessionStorage.clear();
                window.location.reload();
            })
            break;
        case 429:
            VueSimpleAlert.alert("Too many, requests","Throttled","error")
            break;
        case 503: // Down for maintenance
            // Bounce the user to the login screen with a redirect back
            VueSimpleAlert.alert("We're sorry, our site is down for maintenance, Thank you","Down for maintenance","info")
            api.post('api/logout').then(()=>{
                sessionStorage.clear();
                window.location.reload();

            })
            break;
        case 500:
            VueSimpleAlert.alert('Oops, something went wrong!  The team have been notified.','Error', 'error')
            break;
        default:
            // Allow individual requests to handle other errors
            return Promise.reject(error);
    }
});

// window.Echo = new Echo({
//     authEndpoint : 'http://localhost:8000/broadcasting/auth',
//     broadcaster: 'pusher',
//     key: '410753cda4969a0b8071',
//     cluster: 'ap1',
//     forceTLS: true,
//     auth: {
//         headers: {
//             'X-CSRF-Token': "CSRF_TOKEN"
//          }
//       }
// });
//window.Echo.connector.pusher.config.authEndpoint = `http://localhost:8000/broadcasting/auth`;

// import Echo from 'laravel-echo';

// const client = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: '410753cda4969a0b8071',
//     cluster: 'ap1',
//     client: client
// });
import './assets/css/tailwind.css'
window.$ = window.jQuery = require('jquery');
createApp(App).use(router).mount('#app')
