<template>
    <v-btn @click="$router.push('/import-transactions')">Import</v-btn>
    <div>
        Here users will be able to see only transactions, filtering by category
        or period
    </div>
</template>

<script setup lang="ts">
definePageMeta({
    title: "Transactions",
    middleware: ["verified"],
    name: "transactions",
    template: "default",
});
</script>

<style scoped></style>
