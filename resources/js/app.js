require('./bootstrap');

import 'accordion-js/dist/accordion.min.css';
import Accordion from 'accordion-js';

document.querySelector('.accordion-container') ? new Accordion('.accordion-container') : null;

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
