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
        <h1>{{ data.title }}</h1>

        <div class="projects">
            <div v-for="project in data.projects" :key="project.id">
                <h2>{{ project.title }}</h2>
                <img :src="project.picture" :alt="project.title">
                <p>{{ project.content }}</p>
            </div>
        </div>

        <RouterLink :to="{name: 'categories'}">{{ $t("button.all_categories") }}</RouterLink>

    </div>
</template>

<style scoped>
.projects {
    display: flex;
    flex-flow: row wrap;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5em;
}

h2 {
    margin-bottom: 0.8em;
}

.projects > div {
    flex: 0 0 47%;
}

.projects > div > img {
    width: 100%;
    height: auto;
    margin-bottom: 0.8em;
}
</style>