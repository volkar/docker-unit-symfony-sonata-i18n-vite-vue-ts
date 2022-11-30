<script setup lang="ts">
import MainMenu from '@/components/MainMenu/MainMenu.vue'
import { reactive } from 'vue'
import { useI18n } from 'vue-i18n'
import router from '@/router/index.js'

const i18n = useI18n({ useScope: 'global' });

const languages = reactive([{code: 'en', title: 'English'}, {code: 'it', title: 'Italian'}]);

const switchLanguage = (newLang) => {
    i18n.locale.value = newLang
    // Set document lang attr
    document.documentElement.lang = newLang
    // Store locale (for "/" redirect later instead of default locale)
    localStorage.setItem('locale', newLang)
    // Push router with new locale
    const currentPath = router.currentRoute.value.fullPath;
    const splittedPath = currentPath.split("/");
    splittedPath[1] = newLang;
    router.push(splittedPath.join('/'))
}

</script>

<template>

    <div v-if="languages.length > 1" class="lang-block">
        <a href="#" v-for="l in languages" @click.prevent="switchLanguage(l.code)" v-bind:key="l.code" :class="{ active: l.code === $i18n.locale }">{{ l.title }}</a>
    </div>

    <MainMenu />

    <RouterView />

    <hr />

    <a href="https://vitejs.dev" target="_blank">
        <img alt="Vite logo" class="logo vite" src="./gfx/vite.svg" />
    </a>
    <a href="https://pinia.vuejs.org" target="_blank">
        <img alt="Pinia logo" class="logo pinia" src="./gfx/pinia.svg" />
    </a>
    <a href="https://vuejs.org" target="_blank">
        <img alt="Vue logo" class="logo vue" src="./gfx/vue.svg" />
    </a>


</template>

<style src="@/styles/reset.css"></style>
<style src="@/styles/styles.css"></style>

<style scoped>
    .lang-block {
        text-align: center;
        margin-bottom: 1em;
    }
    .lang-block a {
        padding: 0.2em 1em;
        display: inline-block
    }
    .lang-block a.active {
        color: rgba(255, 255, 255, 0.87);
    }
</style>