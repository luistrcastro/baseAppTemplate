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
                <span class="text-h5">Category</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-select
                    class="mr-2"
                    density="compact"
                    label="Parent Category"
                    :items="categories"
                    item-title="name"
                    item-value="id"
                />
                <BasicInputField
                    v-model="category.name"
                    :disabled="inProgress"
                    label="Name*"
                    :validation="rules.name"
                />
                <BasicInputField
                    v-model="category.icon"
                    :disabled="inProgress"
                    label="Icon*"
                    :validation="rules.icon"
                />
                <BasicInputField
                    v-model="category.color"
                    :disabled="inProgress"
                    label="Color*"
                    :validation="rules.color"
                />
                <BasicInputField
                    v-model="category.description"
                    :disabled="inProgress"
                    label="Description"
                />
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-btn
                    color="error"
                    :disabled="inProgress"
                    :loading="inProgress"
                    @click="closeDialog"
                >
                    Close
                </v-btn>
                <v-btn
                    color="primary"
                    :disabled="inProgress"
                    :loading="inProgress"
                    @click="submit"
                >
                    Submit
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script setup lang="ts">
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";

const category = reactive({
    name: null,
    icon: null,
    color: null,
    description: null,
    parent_category_id: null,
});
const rules = computed(() => {
    return {
        icon: { required },
        name: { required },
        color: { required },
    };
});
const v$ = useVuelidate();

const emit = defineEmits(["update:isDialogActive"]);

function closeDialog() {
    emit("update:isDialogActive", false);
}

const categories = computed(() =>
    useCategoryStore().index.sort((a, b) => (a.name > b.name ? 1 : -1))
);

const inProgress = ref(false);
async function submit() {
    if (!(await v$.value.$validate())) {
        useSnackbarStore().SHOW_MESSAGE({
            content: "Invalid Inputs",
            color: "error",
        });
    }
    try {
        inProgress.value = true;
        await useCategoryStore().addItem({
            ...category,
            slug: `${category.name}`.toLowerCase(),
        });
        closeDialog();
    } catch (error) {
        // TODO handle error
        console.log(error);
    }
}
</script>

<style scoped></style>
