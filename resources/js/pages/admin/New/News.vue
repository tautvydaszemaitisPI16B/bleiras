<script setup>
import { ref } from 'vue'

import Button from 'primevue/button'
import ConfirmDialog from 'primevue/confirmdialog'
import Toast from 'primevue/toast'

import { useConfirm } from 'primevue/useconfirm'
import { useToast } from 'primevue/usetoast'

import AppLayout from '../../../layouts/AppLayout.vue'

import NewsList from '../../../components/New/NewsList.vue'
import NewsFormDialog from './NewsFormDialog.vue'
import NewsActions from './NewsActions.vue'

import {
    storeNews,
    updateNews,
    deleteNews,
} from '@/services/new.js'

const confirm = useConfirm()
const toast = useToast()

const newsList = ref(null)

const dialogVisible = ref(false)
const saving = ref(false)

const selectedNews = ref(null)

const errors = ref({})

const openCreate = () => {
    errors.value = {}
    selectedNews.value = null
    dialogVisible.value = true
}

const edit = (item) => {
    errors.value = {}
    selectedNews.value = item
    dialogVisible.value = true
}

const closeDialog = () => {
    dialogVisible.value = false
    selectedNews.value = null
    errors.value = {}
}

const submit = async (payload) => {
    saving.value = true
    errors.value = {}

    try {
        if (selectedNews.value) {
            await updateNews(
                selectedNews.value.id,
                payload
            )

            await newsList.value?.reload()

            toast.add({
                severity: 'success',
                summary: 'Atnaujinta',
                detail: 'Naujiena sėkmingai atnaujinta.',
                life: 3000,
            })
        } else {
            await storeNews(payload)

            await newsList.value?.reloadFirstPage()

            toast.add({
                severity: 'success',
                summary: 'Sukurta',
                detail: 'Naujiena sėkmingai sukurta.',
                life: 3000,
            })
        }

        closeDialog()
    } catch (error) {
        if (error.response?.status === 422) {
            errors.value =
                error.response.data.errors ?? {}

            return
        }

        console.error(error)

        toast.add({
            severity: 'error',
            summary: 'Klaida',
            detail: selectedNews.value
                ? 'Nepavyko atnaujinti naujienos.'
                : 'Nepavyko sukurti naujienos.',
            life: 3000,
        })
    } finally {
        saving.value = false
    }
}

const remove = (item) => {
    confirm.require({
        message: `Ar tikrai norite ištrinti „${item.title}“?`,
        header: 'Naujienos ištrynimas',
        icon: 'pi pi-exclamation-triangle',

        acceptLabel: 'Ištrinti',
        rejectLabel: 'Atšaukti',

        acceptClass: 'p-button-danger',
        rejectClass:
            'p-button-secondary p-button-outlined',

        accept: async () => {
            try {
                await deleteNews(item.id)

                await newsList.value?.reload()

                toast.add({
                    severity: 'success',
                    summary: 'Ištrinta',
                    detail: 'Naujiena sėkmingai ištrinta.',
                    life: 3000,
                })
            } catch (error) {
                console.error(error)

                toast.add({
                    severity: 'error',
                    summary: 'Klaida',
                    detail:
                        'Nepavyko ištrinti naujienos.',
                    life: 3000,
                })
            }
        },
    })
}
</script>

<template>
    <AppLayout>
        <Toast />
        <ConfirmDialog />

        <div class="page-header">
            <div>
                <h1>
                    Naujienų administravimas
                </h1>

                <p>
                    Kurkite, redaguokite ir šalinkite
                    naujienas.
                </p>
            </div>

            <Button
                label="Pridėti naujieną"
                icon="pi pi-plus"
                @click="openCreate"
            />
        </div>

        <NewsList ref="newsList">
            <template #actions="{ item }">
                <NewsActions
                    :item="item"
                    @edit="edit"
                    @remove="remove"
                />
            </template>
        </NewsList>

        <NewsFormDialog
            v-model:visible="dialogVisible"
            :news="selectedNews"
            :saving="saving"
            :errors="errors"
            @submit="submit"
        />
    </AppLayout>
</template>

<style scoped>
.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
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
