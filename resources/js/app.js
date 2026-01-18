import { createApp } from 'vue';
import 'bootstrap/dist/css/bootstrap.css';
import './bootstrap';
import 'bootstrap-icons/font/bootstrap-icons.css';


import Login from './components/Login.vue';
import Register from './components/Register.vue';
import Dashboard from './components/Dashboard.vue';

const el = document.getElementById('app');
const path = window.location.pathname;

let Component = null;

if (path === '/login') {
  Component = Login;
  document.title = 'Login';
} else if (path === '/register') {
  Component = Register;
  document.title = 'Register';
} else {
  Component = Dashboard;
  document.title = 'Dashboard';
}

if (el && Component) {
  createApp(Component).mount('#app');
}
