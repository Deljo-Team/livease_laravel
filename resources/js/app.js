import './bootstrap';
import './admin/sidebar'; 
import 'laravel-datatables-vite';
import Admin from './admin'
import Swal from 'sweetalert2'
import axios from 'axios';

window.swal = Swal;
window.axios = axios;
window.admin = new Admin();
