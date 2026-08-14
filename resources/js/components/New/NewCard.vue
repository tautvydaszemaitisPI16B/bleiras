<script setup>
import { useRouter } from 'vue-router'

import Card from 'primevue/card'

defineProps({
    item: {
        type: Object,
        required: true,
    },
})

const router = useRouter()

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

const openNews = (item) => {
    router.push({
        name: 'news.show',
        params: {
            id: item.id,
        },
    })
}
</script>

<template>
    <Card
        class="news-card"
        @click="openNews(item)"
    >
        <template #title>
            {{ item.title }}
        </template>

        <template #subtitle>
            <span
                v-if="item.published_at"
                class="published-at"
            >
                <i class="pi pi-calendar"></i>

                Publikuota:
                {{ formatDate(item.published_at) }}
            </span>
        </template>

        <template #content>
            <p class="news-content">
                {{ item.content }}
            </p>
        </template>

        <template
            v-if="$slots.actions"
            #footer
        >
            <div @click.stop>
                <slot name="actions" />
            </div>
        </template>
    </Card>
</template>

<style scoped>
.news-card {
    cursor: pointer;
    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease;
}

.news-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
}

.news-content {
    white-space: pre-line;
}

.published-at {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.875rem;
    color: var(--p-surface-500);
}
</style>
