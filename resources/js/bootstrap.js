import axios from 'axios';
import * as bootstrap from 'bootstrap';

window.axios = axios;
window.bootstrap = bootstrap;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;

const token = document.querySelector('meta[name="csrf-token"]'); //attach token

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.getAttribute('content');
} else {
  console.error('CSRF token not found');
}
