<template>
    <basic-select
        v-bind="props"
        :data="iconsComputed"
        itemTitle="title"
        itemValue="value"
        @update:modelValue="updateValue"
    >
        <template #selection="{ item }">
            <p class="selected-option" style="max-width: 120px">
                <v-icon class="mr-2" :icon="`mdi-${item.value}`" />
                {{ item.title }}
            </p>
        </template>
    </basic-select>
</template>

<script setup lang="ts">
import titleCase from "~/helpers/titleCase";

const emit = defineEmits(["update:modelValue"]);

interface Props {
    inline: boolean;
    label?: string;
    modelValue: number | null;
}
const props = withDefaults(defineProps<Props>(), {
    inline: false,
    label: "Icon",
});

function updateValue(value: string | object | null) {
    emit("update:modelValue", value);
}

const icons = [
    "hair-dryer-outline",
    "glass-mug-variant",
    "school-outline",
    "flash-outline",
    "basket-outline",
    "home-outline",
    "shield-check-outline",
    "access-point",
    "hospital-box-outline",
    "home-city-outline",
    "silverware-fork-knife",
    "paw",
    "cash-multiple",
    "train-car",
    "youtube-tv",
    "bicycle-basket",
    "devices",
    "hand-coin-outline",
    "ticket",
    "credit-card-outline",
    "gift-outline",
    "airplane-takeoff",
    "bank-transfer-out",
    "coffee",
    "cash-plus",
    "bitcoin",
    "car-hatchback",
    "baby-carriage",
    "bank-transfer",
    "bank-transfer-in",
];

const iconsComputed = icons.map((e) => ({
    title: titleCase(e),
    value: e,
    props: { prependIcon: `mdi-${e}` },
}));
</script>

<style scoped>
.selected-option {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
