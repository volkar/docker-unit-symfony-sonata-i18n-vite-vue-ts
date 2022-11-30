<script setup lang="ts">
import { toRefs, ref } from "vue";
import { useGetRequest } from "@/use/useFetchRequest";

const props = defineProps<{ url: string }>()
const { url } = toRefs(props);

const data = ref()
const error = ref()
const isLoading = ref(true)

useGetRequest(url, url).then((result) => {
    data.value = result
}).catch((err) => {
    error.value = err
}).finally(() => {
    isLoading.value = false
})

</script>

<template>
    <div v-if="isLoading">Loading...</div>
    <div v-else-if="error">
        Error: {{ error.message }}
    </div>
    <div v-else-if="data">
        <h1>{{ $t("mainmenu.categories") }}</h1>
        <div class="categories">
            <div v-for="category in data" :key="category.id" class="category">
                <RouterLink :to="{name: 'categoryDetails', params: {slug: category.slug }}">{{ category.title }}</RouterLink> (<strong>{{ category.projects_count }}</strong>)
            </div>
        </div>
    </div>
</template>


<style scoped>
.categories {
    display: flex;
    flex-flow: row wrap;
    justify-content: center;
    align-items: flex-start;
}
.category {
    padding: 1em;
    background-color: rgba(0, 0, 0, 0.2);
    text-align: left;
    margin: 0 1em;
}
</style>