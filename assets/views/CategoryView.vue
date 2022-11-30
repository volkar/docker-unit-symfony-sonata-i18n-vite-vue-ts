<script setup lang="ts">
import { computed } from 'vue'
import { getGlobalLocale } from "@/utils/locale";
import Category from "@/components/Category.vue";
import { useRoute } from "vue-router";

const route = useRoute()
const getApiQuery = computed(() => {
    return '/api/' + getGlobalLocale() + '/getCategory/' + route.params.slug;
})
</script>

<template>
    <article>
        <Category :url="getApiQuery" :key="getApiQuery"></Category>
    </article>
</template>