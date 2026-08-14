<script setup>
import { onMounted, ref } from 'vue'
import AppLayout from '../layouts/AppLayout.vue'
import NewsList from '../components/New/NewsList.vue'

const news = ref([])
</script>

<template>
    <AppLayout>
        <div class="page-header">
            <h1>Naujienos</h1>

            <p>
                Naujausios mūsų paskelbtos naujienos.
            </p>
        </div>

        <NewsList :news="news" />
    </AppLayout>
</template>

<style scoped>
.page-header {
    margin-bottom: 2rem;
}

.page-header h1 {
    margin: 0 0 0.5rem;
    font-size: 2rem;
}

.page-header p {
    margin: 0;
    color: var(--p-surface-500);
}
</style>
