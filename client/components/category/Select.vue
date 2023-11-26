<template>
    <v-select
        v-model="inputValue"
        clearable
        :items="categories"
        item-value="id"
        item-title="name"
        label="Category"
        v-bind="layout"
    ></v-select>
</template>

<script setup lang="ts">
import { VSelect } from "vuetify/lib/components/index.mjs";
const emit = defineEmits(["update:modelValue"]);

interface Props {
    inline?: boolean;
    modelValue: number | null;
    noChildren?: boolean;
    showHidden?: boolean;
}
const props = withDefaults(defineProps<Props>(), {
    inline: false,
    noChildren: false,
    showHidden: false,
});

const inputValue = computed({
    get() {
        return props.modelValue;
    },
    set(value) {
        emit("update:modelValue", value);
    },
});

const categoryStore = useCategoryStore();
const categories = computed(() => {
    if (props.showHidden) return categoryStore.index;
    if (props.noChildren) return categoryStore.filterOutChildren;
    return categoryStore.getNotHidden;
});

const layout = <VSelect["$props"]>computed(() => {
    if (props.inline) return { density: "compact", hideDetails: true };
});
</script>
