<script setup>
defineProps(['errors']);
</script>

<template>
    <div class="mt-2">
        <p class="text-sm text-red-600" v-for="error in errors">{{ error }}</p>
    </div>
</template>
