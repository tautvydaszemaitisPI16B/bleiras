<script setup>
import { useRouter } from 'vue-router'
import { getCurrentUser } from '../router'
import axios from 'axios'

const router = useRouter()
const user = getCurrentUser()

const openAdmin = () => {
    router.push(user ? '/admin' : '/login')
}

const logout = async () => {
    try {
        await axios.post('/logout')

        router.push('/')
        router.go(0)
    } catch (error) {
        console.error('Nepavyko atsijungti', error)
    }
}
</script>

<template>
    <div class="app-layout">
        <header class="header">
            <RouterLink to="/" class="logo">
                Bleiras
            </RouterLink>

            <div class="header-actions">
                <template v-if="user">
                    <Button
                        label="Administruoti"
                        icon="pi pi-cog"
                        @click="openAdmin"
                    />

                    <Button
                        label="Atsijungti"
                        icon="pi pi-sign-out"
                        severity="secondary"
                        outlined
                        @click="logout"
                    />
                </template>

                <Button
                    v-else
                    label="Prisijungti"
                    icon="pi pi-sign-in"
                    outlined
                    @click="router.push('/login')"
                />
            </div>
        </header>

        <main class="content">
            <slot />
        </main>
    </div>
</template>

<style scoped>
.app-layout {
    min-height: 100vh;
    background: var(--p-surface-50);
}

.header {
    height: 72px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 2rem;
    background: var(--p-surface-0);
    border-bottom: 1px solid var(--p-surface-200);
}

.logo {
    font-size: 1.25rem;
    font-weight: 700;
    text-decoration: none;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.content {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 3rem 2rem;
}

</style>
