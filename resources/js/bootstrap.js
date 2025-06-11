
import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import alpinejs from 'alpinejs';
window.Alpine = alpinejs;
