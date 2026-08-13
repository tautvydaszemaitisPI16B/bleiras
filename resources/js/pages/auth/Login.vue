<script setup>
import { reactive, ref } from 'vue'
import { useRouter, useRoute } from 'vue-router'

import AuthLayout from '../../layouts/AuthLayout.vue'
import { login } from '../../services/auth'
import { setCurrentUser } from '../../router'

const router = useRouter()
const route = useRoute()
const loading = ref(false)
const error = ref('')

const form = reactive({
    email: '',
    password: '',
    remember: false,
})

const submit = async () => {
    loading.value = true
    error.value = ''

    try {
        const response = await login(form)

        setCurrentUser(response.user)

        await router.push(
            route.query.redirect || {
                name: 'admin.news',
            }
        )
    } catch (e) {
        console.error(e)

        error.value =
            e.response?.data?.errors?.email?.[0]
            ?? e.response?.data?.message
            ?? 'Nepavyko prisijungti.'
    } finally {
        loading.value = false
    }
}
</script>

<template>
    <AuthLayout>
        <div class="login">

            <div class="login-header">
                <h1>Prisijungimas</h1>

                <p>
                    Įveskite prisijungimo duomenis.
                </p>
            </div>

            <Message
                v-if="error"
                severity="error"
                :closable="false"
                class="login-error"
            >
                {{ error }}
            </Message>

            <form @submit.prevent="submit">
                <div class="form-field">
                    <label for="email">
                        El. paštas
                    </label>

                    <InputText
                        id="email"
                        v-model="form.email"
                        type="email"
                        placeholder="admin@example.com"
                        autocomplete="email"
                        fluid
                    />
                </div>

                <div class="form-field">
                    <label for="password">
                        Slaptažodis
                    </label>

                    <Password
                        id="password"
                        v-model="form.password"
                        placeholder="Įveskite slaptažodį"
                        autocomplete="current-password"
                        :feedback="false"
                        toggleMask
                        fluid
                    />
                </div>

                <div class="login-options">
                    <div class="remember">
                        <Checkbox
                            v-model="form.remember"
                            inputId="remember"
                            binary
                        />

                        <label for="remember">
                            Prisiminti mane
                        </label>
                    </div>
                </div>

                <Button
                    type="submit"
                    label="Prisijungti"
                    icon="pi pi-sign-in"
                    :loading="loading"
                    fluid
                />
            </form>
        </div>
    </AuthLayout>
</template>

<style scoped>

.logo-icon {
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: var(--p-primary-500);
    color: white;
}

.login-header {
    margin-bottom: 2rem;
}

.login-header h1 {
    margin: 0 0 0.6rem;
    color: var(--p-surface-950);
    font-size: 2rem;
    letter-spacing: -0.03em;
}

.login-header p {
    margin: 0;
    color: var(--p-surface-500);
    line-height: 1.6;
}

.login-error {
    margin-bottom: 1.5rem;
}

.form-field {
    margin-bottom: 1.4rem;
}

.form-field label {
    display: block;
    margin-bottom: 0.55rem;
    color: var(--p-surface-700);
    font-size: 0.9rem;
    font-weight: 600;
}

.login-options {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
}

.remember {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    color: var(--p-surface-600);
    font-size: 0.9rem;
}
</style>
