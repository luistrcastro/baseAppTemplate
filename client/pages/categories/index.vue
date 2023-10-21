<template>
    <div class="w-100 d-flex justify-end">
        <v-btn class="mr-2" @click="openBaseCategoriesDialog"
            >Common Categories</v-btn
        >
        <v-btn @click="openCategoryDialog">Add Category</v-btn>
    </div>
    <v-data-table
        :headers="headers"
        :items="categories"
        :loading="!isReady ? 'primary' : null"
        noDataText="You don't have any categories yet. You can create your own or import
        from common categories."
    >
        <template #item.icon="{ item, value }">
            <v-icon :icon="`mdi-${value}`" :color="item.color"></v-icon>
        </template>
    </v-data-table>

    <category-base-dialog
        v-if="baseCategoriesDialog"
        key="base-categories"
        v-model:isDialogActive="baseCategoriesDialog"
    />
    <category-dialog
        v-if="categoryDialogActive"
        key="category-dialog"
        v-model:isDialogActive="categoryDialogActive"
        :selectedCategory="selectedCategory"
    />
</template>

<script setup lang="ts">
import useCategoryStore from "~/stores/useCategoryStore";

definePageMeta({
    title: "Categories",
    middleware: ["verified"],
    name: "categories",
    template: "default",
});

const categoryStore = useCategoryStore();
const categories = computed(() => categoryStore.index);
const isReady = categoryStore.storeReady;

const baseCategoriesDialog = ref(false);
function openBaseCategoriesDialog() {
    baseCategoriesDialog.value = true;
}

const categoryDialogActive = ref(false);
const selectedCategory = reactive({});
function openCategoryDialog() {
    categoryDialogActive.value = true;
}

const headers = [
    { title: "Icon/Color", key: "icon", outerWidth: 150 },
    { title: "Name", key: "name" },
    { title: "Description", key: "description" },
];
</script>

<style scoped></style>
