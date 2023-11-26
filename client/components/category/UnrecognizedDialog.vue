<template>
    <v-dialog
        :modelValue="true"
        overlay-color="black"
        overlay-opacity="0.7"
        max-width="1200px"
        scrollable
        @update:modelValue="closeDialog"
    >
        <v-card>
            <v-card-title>
                <span class="text-h5">Unrecognized Categories</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-data-table :items="categoriesArray" :headers="headers">
                    <template #item.name="{ item }">
                        <div style="min-width: 300px"></div>
                        <basic-input-field v-model="item.name" inline />
                    </template>
                    <template #item.description="{ item }">
                        <basic-input-field v-model="item.description" inline />
                    </template>
                    <template #item.icon="{ item }">
                        <div style="width: 100px"></div>
                        <basic-icon-select v-model="item.icon" inline />
                    </template>
                    <template #item.color="{ item }">
                        <basic-colour-picker v-model="item.color" />
                    </template>
                    <template #item.parent_category_id="{ item }">
                        <category-select
                            v-model="item.parent_category_id"
                            inline
                            noChildren
                            @update:modelValue="syncMonthBudget($event, item)"
                        />
                    </template>
                    <template #item.month_budget_id="{ item }">
                        <month-budget-select
                            v-model="item.month_budget_id"
                            :categoryId="item.parent_category_id"
                            :readonly="!!item.parent_category_id"
                            inline
                        />
                    </template>
                    <template #header.is_hidden>
                        <div class="d-inline-flex">
                            Is Hidden
                            <v-checkbox
                                v-model="hideAll"
                                @update:modelValue="toggleHideAll"
                            />
                        </div>
                    </template>
                    <template #item.is_hidden="{ item }">
                        <v-checkbox-btn
                            v-model="item.is_hidden"
                            color="info"
                            hide-details
                        />
                    </template>
                </v-data-table>
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

interface Props {
    categories: string[];
}
const props = defineProps<Props>();

const headers = [
    { title: "Name", key: "name" },
    { title: "Description", key: "description" },
    { title: "Icon", key: "icon" },
    { title: "Color", key: "color" },
    { title: "Parent Category", key: "parent_category_id" },
    { title: "Month Budget", key: "month_budget_id" },
    { title: "Hidden", key: "is_hidden" },
];

const hideAll = ref(false);

const categoriesArray = ref(<ICategory[]>[]);
onBeforeMount(() => {
    categoriesArray.value = props.categories.map((label) => ({
        name: removeNumberBlocks(label),
        icon: null,
        color: toColor(label),
        description: null,
        parent_category_id: null,
        id: null,
        is_hidden: false,
        user_id: null,
        month_budget_id: null,
    }));
});

const inProgress = ref(false);

function closeDialog() {
    emit("update:isDialogActive", false);
}

function removeNumberBlocks(str: string) {
    return str
        .split(" ")
        .filter((part: string) => !Number(part))
        .join(" ");
}

function submit() {}

function toColor(str: string) {
    let words = str
        .split(/[\s-]+/)
        .map((word) => word.substring(0, 1))
        .join("")
        .substring(0, 3)
        .toUpperCase();

    words = `${words} softly does it `;

    let i;
    let hash = 0;
    for (i = 0; i < words.length; i++) {
        hash = words.charCodeAt(i) + ((hash << 5) - hash);
    }
    let colour = "#";
    for (i = 0; i < 3; i++) {
        const value = (hash >> (i * 8)) & 0xff;
        colour += `00${value.toString(16)}`.slice(-2);
    }
    return colour;
}

function toggleHideAll(value: boolean) {
    categoriesArray.value = categoriesArray.value.map((e) => ({
        ...e,
        is_hidden: value,
    }));
}

function syncMonthBudget(categoryId: number, item) {
    const foundItem = categoriesArray.value.find((e) => e.id === item.id);
    foundItem.month_budget_id =
        useCategoryStore().getById(categoryId)?.month_budget_id;
}
</script>
