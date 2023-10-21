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
                <span class="text-h5">Unrecognized Categories</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-data-table
                    :items="categoriesArray"
                    :headers="headers"
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
import { ICategory } from "~/contracts/stores/Category";

const emit = defineEmits(["update:isDialogActive"]);
const props = defineProps({
    categories: { type: Array, required: true },
});

const headers = [
    { title: "Name", key: "name" },
    { title: "Description", key: "description" },
    { title: "Icon", key: "icon" },
    { title: "Color", key: "color" },
    { title: "Parent Category", key: "parent_category_id" },
    { title: "Month Budget", key: "month_budget_id" },
];

const categoriesArray = ref(<ICategory[]>[]);
onBeforeMount(() => {
    categoriesArray.value = props.categories.map((label) => ({
        name: label,
        icon: null,
        color: null,
        description: null,
        parent_category_id: null,
        id: null,
        user_id: null,
        month_budget_id: null,
    }));
});

const inProgress = ref(false);

function closeDialog() {
    emit("update:isDialogActive", false);
}

function submit() {}
</script>
