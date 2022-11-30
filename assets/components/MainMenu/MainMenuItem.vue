<script setup lang="ts">
defineProps<{ menuTitle: string, menuTo: object }>()
</script>

<template>
    <li>
        <RouterLink :to="menuTo">
            {{ menuTitle }}
        </RouterLink>
    </li>
</template>