require('./bootstrap');
require('./validation/index');

import Vue from 'vue'
import App from './views/App'
import router from './router/index';
import store from './store/index'
import {baseurl} from './base_url'

import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');

window.axios = axios;

// Get the JWT token from local storage (assuming you store it there)
let token = localStorage.getItem('token');

// If the token exists, include it in all Axios requests
if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}


window.Echo = new Echo({
    broadcaster: 'pusher',
    key: "f355fe36b8d8d50e37b3",
    cluster: "ap2",
    encrypted: true,
    auth: {
        headers: {
            Authorization: `Bearer ${token}`,  // Add JWT token in the authorization header
        },
    }
});

// main origin
Vue.prototype.mainOrigin = baseurl


//Multi select
//Vue Multiselect
import Multiselect from 'vue-multiselect'
Vue.component('multiselect', Multiselect)
//Bus to transfer data
export const bus = new Vue();

//Toaster
import Toaster from 'v-toaster'
import 'v-toaster/dist/v-toaster.css'
Vue.use(Toaster, {timeout: 5000})

//moment
import moment from 'moment'


//Component
Vue.component('skeleton-loader', require('./components/loaders/Straight').default);
Vue.component('submit-form', require('./components/buttons/Submit').default);
Vue.component('advanced-datatable', require('./components/datatable/Advanced').default);
Vue.component('breadcrumb', require('./components/layouts/Breadcrumb').default);
Vue.component('data-export', require('./components/datatable/Export').default);
Vue.component('add-edit-user',require('./components/users/AddEditModal').default);
Vue.component('reset-password',require('./components/users/Editpassword').default);
Vue.component('submit-form', require('./components/buttons/Submit').default);



const app = new Vue({
    el: '#app',
    store: store,
    components: {App},
    router,
});
