<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    visible: {
        type: Boolean,
        default: false,
    },

    news: {
        type: Object,
        default: null,
    },

    saving: {
        type: Boolean,
        default: false,
    },

    errors: {
        type: Object,
        default: () => ({}),
    },
})

const emit = defineEmits([
    'update:visible',
    'submit',
])

const form = ref({
    title: '',
    content: '',
    published_at: null,
})

const isEditing = () => !!props.news?.id

const resetForm = () => {
    form.value = {
        title: '',
        content: '',
        published_at: null,
    }
}

watch(
    () => [props.visible, props.news],
    () => {
        if (!props.visible) {
            return
        }

        if (props.news) {
            form.value = {
                title: props.news.title ?? '',
                content: props.news.content ?? '',
                published_at: props.news.published_at
                    ? new Date(props.news.published_at)
                    : null,
            }

            return
        }

        resetForm()
    },
    {
        immediate: true,
        deep: true,
    }
)

const close = () => {
    emit('update:visible', false)
}

const submit = () => {
    emit('submit', {
        title: form.value.title,
        content: form.value.content,
        published_at: form.value.published_at,
    })
}
</script>

<template>
    <Dialog
        :visible="visible"
        modal
        :header="
            isEditing()
                ? 'Redaguoti naujieną'
                : 'Kurti naujieną'
        "
        :style="{ width: '32rem' }"
        @update:visible="$emit('update:visible', $event)"
    >
        <form
            class="news-form"
            @submit.prevent="submit"
        >
            <div class="field">
                <label for="title">
                    Pavadinimas
                </label>

                <InputText
                    id="title"
                    v-model="form.title"
                    fluid
                    :invalid="!!errors.title"
                />

                <small
                    v-if="errors.title"
                    class="error"
                >
                    {{ errors.title[0] }}
                </small>
            </div>

            <div class="field">
                <label for="content">
                    Turinys
                </label>

                <Textarea
                    id="content"
                    v-model="form.content"
                    rows="8"
                    autoResize
                    fluid
                    :invalid="!!errors.content"
                />

                <small
                    v-if="errors.content"
                    class="error"
                >
                    {{ errors.content[0] }}
                </small>
            </div>

            <div class="field">
                <label for="published_at">
                    Publikavimo data
                </label>

                <DatePicker
                    id="published_at"
                    v-model="form.published_at"
                    dateFormat="yy-mm-dd"
                    showTime
                    hourFormat="24"
                    showIcon
                    fluid
                    :invalid="!!errors.published_at"
                    placeholder="Palikus tuščią bus naudojama dabartinė data"
                />

                <small
                    v-if="errors.published_at"
                    class="error"
                >
                    {{ errors.published_at[0] }}
                </small>
            </div>

            <div class="dialog-actions">
                <Button
                    type="button"
                    label="Atšaukti"
                    severity="secondary"
                    @click="close"
                />

                <Button
                    type="submit"
                    :label="
                        isEditing()
                            ? 'Išsaugoti'
                            : 'Sukurti'
                    "
                    icon="pi pi-check"
                    :loading="saving"
                />
            </div>
        </form>
    </Dialog>
</template>

<style scoped>
.news-form {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.field {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.field label {
    font-weight: 600;
}

.error {
    color: var(--p-red-500);
}

.dialog-actions {
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

</style>
