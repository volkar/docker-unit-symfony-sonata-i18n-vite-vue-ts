<script setup lang="ts">
import { computed } from "vue";
import Page from '@/components/Page.vue'
import { getGlobalLocale } from "@/utils/locale";

const getApiQuery = computed(() => {
    return '/api/' + getGlobalLocale() + '/getPage/about';
})
</script>

<template>
    <article>
        <Page :url="getApiQuery" :key="getApiQuery"></Page>
    </article>
</template>
