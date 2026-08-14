import './bootstrap'
import '../css/app.css'
import 'primeicons/primeicons.css'

import { createApp } from 'vue'
import PrimeVue from 'primevue/config'
import Aura from '@primeuix/themes/aura'
import ConfirmationService from 'primevue/confirmationservice'
import ToastService from 'primevue/toastservice'
import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(PrimeVue, {
    theme: {
        preset: Aura,
    },
})

app.use(router)
app.use(ConfirmationService)
app.use(ToastService)
app.mount('#app')
