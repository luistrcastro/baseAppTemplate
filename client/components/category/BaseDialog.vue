<template>
    <v-dialog
        :modelValue="true"
        overlay-color="black"
        overlay-opacity="0.7"
        max-width="600px"
        scrollable
        @update:modelValue="closeDialog"
    >
        <v-card>
            <v-card-title>
                <span class="text-h5">Common Categories</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-data-table
                    v-model="selectedCategories"
                    :items="baseCategories"
                    :headers="headers"
                    return-object
                    select-strategy="all"
                    show-select
                ></v-data-table>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="grey"
                    :disabled="inProgress"
                    :loading="inProgress"
                    variant="text"
                    @click="closeDialog"
                >
                    Close
                </v-btn>
                <v-btn
                    color="blue darken-1"
                    :disabled="inProgress"
                    :loading="inProgress"
                    variant="text"
                    @click="submit"
                >
                    Save
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script setup lang="ts">
const emit = defineEmits(["update:isDialogActive"]);

function closeDialog() {
    emit("update:isDialogActive", false);
}

const categoryStore = useCategoryStore();
const baseCategories = categoryStore.baseCategories;
const headers = [
    { title: "Name", key: "name" },
    { title: "Description", key: "description" },
];
const selectedCategories = ref([]);
const inProgress = ref(false);
function submit() {
    try {
        inProgress.value = true;
        selectedCategories.value.forEach((category) => {
            categoryStore.addItem(category);
        });
        closeDialog();
    } catch (error) {
        // TODO handle error
        console.log(error);
    }
}
</script>

<style scoped></style>
