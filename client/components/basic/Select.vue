<template>
    <v-select
        v-model="inputValue"
        :label="label"
        :items="data"
        :itemValue="itemValue"
        :itemTitle="itemTitle"
        v-bind="layout"
    >
        <template #item="{ props, item }">
            <slot name="item" :props="props" :item="item">
                <v-list-item v-bind="props"></v-list-item>
            </slot>
        </template>
        <template #selection="{ item, index }">
            <slot name="selection" :item="item" :index="index">
                <span style="white-space: nowrap">{{ item.title }}</span>
            </slot>
        </template>
    </v-select>
</template>

<script setup lang="ts">
import { VSelect } from "vuetify/lib/components/index.mjs";
const emit = defineEmits(["update:modelValue"]);

interface Props {
    data: string[] | object[];
    inline: boolean;
    itemValue: string | null;
    itemTitle: string | null;
    label: string;
    modelValue: number | null;
}
const props = withDefaults(defineProps<Props>(), {
    inline: false,
    itemTitle: "name",
    itemValue: "id",
});

const inputValue = computed({
    get() {
        return props.modelValue;
    },
    set(value) {
        emit("update:modelValue", value);
    },
});

const layout = <VSelect["$props"]>computed(() => {
    if (props.inline) return { density: "compact", hideDetails: true };
});
</script>

<style scoped></style>
