<script setup>
import AppLayout from '../layouts/AppLayout.vue'
</script>

<template>
    <AppLayout>
        <div class="page-header">
            <h1>Naujienos</h1>

            <p>
                Naujausios mūsų paskelbtos naujienos.
            </p>
        </div>

        <div class="news-grid">
            <Card>
                <template #title>
                    Pirma naujiena
                </template>

                <template #content>
                    Naujienos tekstas...
                </template>
            </Card>

            <Card>
                <template #title>
                    Antra naujiena
                </template>

                <template #content>
                    Naujienos tekstas...
                </template>
            </Card>
        </div>
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

.news-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1rem;
}
</style>
