import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from '@/App.vue'
import router from '@/router/index.js'
import { createI18n } from 'vue-i18n'
import en from './locales/en.json'
import it from './locales/it.json'
import { getInitialLocale } from "@/utils/locale";

const i18n = createI18n({
    locale: getInitialLocale(),
    legacy: false,
    allowComposition: true,
    messages: {
        'en': en,
        'it': it,
    }
})

createApp(App).use(i18n).use(createPinia()).use(router).mount('#app')
