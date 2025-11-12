// resources/js/bootstrap.js

// You can add global setup here if needed (like Axios)
import axios from 'axios';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
