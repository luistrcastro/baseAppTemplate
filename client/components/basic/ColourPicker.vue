<template>
    <v-menu location="end">
        <template v-slot:activator="{ props }">
            <v-btn
                v-bind="props"
                :color="inputValue || 'primary'"
                variant="flat"
            />
        </template>
        <v-list
            class="pa-0 ma-0"
            style="width: fit-content; height: fit-content"
        >
            <v-color-picker
                v-model="inputValue"
                hide-inputs
                show-swatches
            ></v-color-picker>
        </v-list>
    </v-menu>
</template>

<script setup lang="ts">
const emit = defineEmits(["update:modelValue"]);

interface Props {
    inline?: boolean;
    label?: string;
    modelValue: string | null;
}
const props = withDefaults(defineProps<Props>(), {
    inline: false,
    label: "Icon",
});

const inputValue = computed({
    get() {
        return props.modelValue;
    },
    set(value) {
        emit("update:modelValue", value);
    },
});
</script>

<style scoped>
.selected-option {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
