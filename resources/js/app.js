require('./bootstrap');

import { createApp } from 'vue';
import App from './pages/App.vue';
import router from './router'

const app = createApp({
    components: {
        App
    }
});

app.use(router);
app.mount('#app');