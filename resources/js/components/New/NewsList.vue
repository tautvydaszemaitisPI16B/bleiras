<script setup>
import { ref, onMounted } from 'vue'

import Paginator from 'primevue/paginator'
import ProgressSpinner from 'primevue/progressspinner'

import NewsCard from './NewCard.vue'
import { getNews } from '@/services/new.js'

const news = ref([])
const loading = ref(false)

const first = ref(0)
const rows = ref(6)
const totalRecords = ref(0)
const currentPage = ref(1)

const loadNews = async (page = 1) => {
    loading.value = true

    try {
        const response = await getNews(
            page,
            rows.value
        )

        news.value = response.data
        totalRecords.value = response.total
        currentPage.value = page
    } finally {
        loading.value = false
    }
}

const reload = async () => {
    await loadNews(currentPage.value)
}

const reloadFirstPage = async () => {
    first.value = 0
    currentPage.value = 1

    await loadNews(1)
}

const onPage = async (event) => {
    first.value = event.first
    rows.value = event.rows

    const page = event.page + 1

    await loadNews(page)
}

onMounted(() => {
    loadNews()
})

defineExpose({
    reload,
    reloadFirstPage,
})
</script>

<template>
    <div>
        <div
            v-if="loading"
            class="loading"
        >
            <ProgressSpinner />
        </div>

        <div
            v-else
            class="news-grid"
        >
            <NewsCard
                v-for="item in news"
                :key="item.id"
                :item="item"
            >
                <template
                    v-if="$slots.actions"
                    #actions
                >
                    <slot
                        name="actions"
                        :item="item"
                    />
                </template>
            </NewsCard>
        </div>

        <Paginator
            :first="first"
            :rows="rows"
            :totalRecords="totalRecords"
            class="paginator"
            @page="onPage"
        />
    </div>
</template>

<style scoped>
.news-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1rem;
}

.loading {
    display: flex;
    justify-content: center;
    padding: 4rem;
}

.paginator {
    margin-top: 2rem;
}

@media (max-width: 900px) {
    .news-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 600px) {
    .news-grid {
        grid-template-columns: 1fr;
    }
}
</style>
