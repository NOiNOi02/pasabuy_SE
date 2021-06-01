import axios from 'axios';
// import app from './main'


const api = axios.create({
    baseURL: `https://pasabuy-server.herokuapp.com/`,
    headers: {
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': '*'
    },
    xsrfCookieName: 'XSRF-TOKEN',
    xsrfHeaderName: 'X-XSRF-TOKEN',
    withCredentials: true
});


export default api;