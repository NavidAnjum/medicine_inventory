require('./bootstrap');
import { createApp } from 'vue';

import add_supplier from "./Components/add_supplier.vue";
import 'sweetalert2/dist/sweetalert2.min.css';

const app =createApp({});
import VueSweetalert2 from 'vue-sweetalert2';
app.use(VueSweetalert2);


app.component('add-supplier',add_supplier);

app.mount('#app')
