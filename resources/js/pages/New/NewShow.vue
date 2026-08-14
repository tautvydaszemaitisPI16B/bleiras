<script setup>
import { onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'

import Button from 'primevue/button'
import Card from 'primevue/card'
import ProgressSpinner from 'primevue/progressspinner'

import AppLayout from '../../layouts/AppLayout.vue'
import { getNew } from '@/services/new.js'

const route = useRoute()
const router = useRouter()

const news = ref(null)
const loading = ref(true)
const error = ref(false)

const formatDate = (date) => {
    if (!date) {
        return ''
    }

    return new Intl.DateTimeFormat('lt-LT', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
    }).format(new Date(date))
}

const loadNews = async () => {
    loading.value = true
    error.value = false

    try {
        news.value = await getNew(route.params.id)
    } catch (e) {
        error.value = true
    } finally {
        loading.value = false
    }
}

onMounted(loadNews)
</script>

<template>
    <AppLayout>
        <div class="news-page">
            <Button
                label="Grįžti į naujienas"
                icon="pi pi-arrow-left"
                severity="secondary"
                text
                class="back-button"
                @click="router.push('/')"
            />

            <div
                v-if="loading"
                class="loading"
            >
                <ProgressSpinner />
            </div>

            <div
                v-else-if="error"
                class="error"
            >
                <i class="pi pi-exclamation-triangle"></i>

                <h2>Naujiena nerasta</h2>

                <p>
                    Nepavyko užkrauti pasirinktos naujienos.
                </p>

                <Button
                    label="Grįžti į naujienas"
                    icon="pi pi-arrow-left"
                    @click="router.push('/')"
                />
            </div>

            <Card
                v-else-if="news"
                class="news-card"
            >
                <template #title>
                    <h1 class="news-title">
                        {{ news.title }}
                    </h1>
                </template>

                <template #subtitle>
                    <div
                        v-if="news.published_at"
                        class="published-at"
                    >
                        <i class="pi pi-calendar"></i>

                        <span>
                            Publikuota:
                            {{ formatDate(news.published_at) }}
                        </span>
                    </div>
                </template>

                <template #content>
                    <div class="news-content">
                        {{ news.content }}
                    </div>
                </template>
            </Card>
        </div>
    </AppLayout>
</template>

<style scoped>
.news-page {
    max-width: 900px;
    margin: 0 auto;
}

.back-button {
    margin-bottom: 1rem;
}

.news-card {
    width: 100%;
}

.news-title {
    margin: 0;
    font-size: 2rem;
    line-height: 1.3;
}

.published-at {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 0.5rem;
    color: var(--p-surface-500);
    font-size: 0.9rem;
}

.news-content {
    margin-top: 1rem;
    font-size: 1.05rem;
    line-height: 1.7;
    white-space: pre-line;
}

.loading {
    display: flex;
    justify-content: center;
    padding: 4rem 0;
}

.error {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    padding: 4rem 1rem;
    text-align: center;
}

.error > i {
    font-size: 3rem;
    color: var(--p-red-500);
}

.error h2,
.error p {
    margin: 0;
}

.error p {
    color: var(--p-surface-500);
}

@media (max-width: 600px) {
    .news-title {
        font-size: 1.5rem;
    }

    .news-content {
        font-size: 1rem;
    }
}
</style>
