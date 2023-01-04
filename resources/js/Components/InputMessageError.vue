<script setup>
defineProps(['error']);
</script>

<template>
    <div class="mt-2">
        <p class="text-sm text-red-600" >{{ error }}</p>
    </div>
</template>
