import { createApp } from 'vue';
import PrimeVue from 'primevue/config';
import Aura from '@primeuix/themes/aura';

import ExampleComponent from './Components/ExampleComponent.vue';
import './bootstrap';
import 'primeicons/primeicons.css';

const app = createApp({});

app.use(PrimeVue, {
    theme: {
        preset: Aura
    }
});

app.component('ExampleComponent', ExampleComponent);

app.mount('#app');
