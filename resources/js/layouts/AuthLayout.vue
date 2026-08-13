<template>
    <div class="auth-layout">
        <div class="auth-brand">
            <div class="brand-content">
            </div>
        </div>

        <main class="auth-content">
            <div class="auth-container">
                <slot />
            </div>
        </main>
    </div>
</template>

<style scoped>
.auth-layout {
    min-height: 100vh;
    display: flex;
    background: #f5f5f5;
}

.auth-brand {
    width: 40%;
    padding: 40px;
    background: #1f2937;
    color: white;
    display: flex;
    flex-direction: column;
}

.brand-content {
    display: flex;
    align-items: center;
    gap: 12px;
}

.auth-content {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 30px;
}

.auth-container {
    width: 100%;
    max-width: 420px;
}
</style>
