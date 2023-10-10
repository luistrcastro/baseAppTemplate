<template>
    <transactions-import />
</template>

<script setup lang="ts">
definePageMeta({
    title: "Import Transactions",
    middleware: ["verified"],
    name: "import-transactions",
    template: "default",
});
</script>

<style scoped></style>
