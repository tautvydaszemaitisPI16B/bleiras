<script setup>
import Button from 'primevue/button'

defineProps({
    item: {
        type: Object,
        required: true,
    },
})

defineEmits([
    'edit',
    'remove',
])
</script>

<template>
    <div class="actions">
        <Button
            label="Redaguoti"
            icon="pi pi-pencil"
            severity="secondary"
            @click="$emit('edit', item)"
        />

        <Button
            label="Ištrinti"
            icon="pi pi-trash"
            severity="danger"
            @click="$emit('remove', item)"
        />
    </div>
</template>

<style scoped>
.actions {
    display: flex;
    gap: 0.5rem;
}
</style>
