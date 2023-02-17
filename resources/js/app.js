/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import { ClientTable } from 'vue-tables-2';
import swal from 'sweetalert2';
import BlockUI from 'vue-blockui';
import ToggleButton from 'vue-js-toggle-button'



require('./bootstrap');
window.Vue = require('vue');
window.Swal = swal;
Vue.use(ToggleButton);
Vue.use(ClientTable);
Vue.use(BlockUI);





/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('inicio-fondo', require('./components/InicioComponent.vue').default);
Vue.component('solicitudes-component', require('./components/SolicitudesComponent.vue').default);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('viaticos-component', require('./components/ViaticosComponent.vue').default);
Vue.component('s-fondo-component', require('./components/SfondoComponent.vue').default);
Vue.component('r-fonod-component', require('./components/RfondoComponent.vue').default);

Vue.component('pagina-uno', require('./components/Pagina_1Component.vue').default);
Vue.component('subdireccion-component', require('./components/SubdireccionComponent.vue').default);  
Vue.component('rendiciones-component', require('./components/RendicionesComponent.vue').default); 
Vue.component('rendiciones-finanza-component', require('./components/RendicionesFinanzaComponent.vue').default);
Vue.component('lista-solicitudes-component', require('./components/ListadesolicitudesComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
