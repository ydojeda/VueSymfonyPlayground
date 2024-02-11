import { createApp } from 'vue'
// import the root component App from a single-file component.
import App from './App.vue'
import router from './router'

const app = createApp(App)
app.use(router)
app.mount('#app')
