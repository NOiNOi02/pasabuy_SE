import axios from 'axios';
// import app from './main'


const api = axios.create({
    baseURL: `http://localhost:8000/`,
    headers: {
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': '*'
    },
    xsrfCookieName: 'XSRF-TOKEN',
    xsrfHeaderName: 'X-XSRF-TOKEN',
    withCredentials: true
});


export default api;