import './stimulus_bootstrap.js';
import './styles/app.css'; //Mis estilos personalizados
import 'bootstrap/dist/css/bootstrap.min.css'; // El CSS de Bootstrap
import 'bootstrap'; // El JS de Bootstrap
import { Modal } from 'bootstrap';
window.bootstrap = { Modal }; // Esto hace que 'bootstrap.Modal' funcione en tus scripts de Twig
console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
