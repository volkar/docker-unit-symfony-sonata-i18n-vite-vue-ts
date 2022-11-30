<script setup lang="ts">
import { computed } from "vue";
import { getGlobalLocale } from "@/utils/locale";
import Categories from "@/components/Categories.vue";

const getApiQuery = computed(() => {
    return '/api/' + getGlobalLocale() + '/getCategories';
})
</script>

<template>
    <article>
        <Categories :url="getApiQuery" :key="getApiQuery"></Categories>
    </article>
</template>