import './assets/main.css'
// import './assets/base.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'

import App from './App.vue'
import router from './router'

import { useIndexStore } from '@/stores/index'
import { onMounted } from 'vue'

const app = createApp(App)

// app.use(createPinia())
const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)

app.use(pinia)
app.use(router)

app.mount('#app')
