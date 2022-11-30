<script setup lang="ts">
import MainMenuItem from "@/components/MainMenu/MainMenuItem.vue"
</script>

<template>
    <ul class="mainmenu">
        <MainMenuItem :menu-to="{name: 'index', params: {locale: $i18n.locale}}" :menu-title="$t('mainmenu.index')"></MainMenuItem>
        <MainMenuItem :menu-to="{name: 'categories', params: {locale: $i18n.locale}}" :menu-title="$t('mainmenu.categories')"></MainMenuItem>
        <MainMenuItem :menu-to="{name: 'about', params: {locale: $i18n.locale}}" :menu-title="$t('mainmenu.about')"></MainMenuItem>
        <li><a href="/admin">{{ $t("mainmenu.admin") }}</a></li>
    </ul>
</template>

<style>
ul.mainmenu {
    background-color: rgba(0, 0, 0, 0.2);
    display: flex;
    flex-flow: row nowrap;
    justify-content: center;
    align-items: flex-start;
}
ul.mainmenu li {
    margin: 0 1em;
}
ul.mainmenu li a {
    padding: 1em;
    display: block;
}
ul.mainmenu li a.router-link-active {
    color: #fff;
    font-weight: 700;
}
</style>