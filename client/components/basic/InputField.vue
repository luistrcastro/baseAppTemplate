<template>
    <v-text-field
        v-model="inputValue"
        v-bind="layout"
        :error-messages="errorMessage"
        @blur="v$.inputValue.$touch"
        @click:append="emit('clickAppend')"
        @click:append-inner="emit('clickAppendInner')"
        @click:prepend="emit('clickPrepend')"
        @click:prepend-inner="emit('clickPrependInner')"
        @keydown="emit('keydown', $event)"
    />
</template>

<script setup lang="ts">
import useVuelidate from "@vuelidate/core";
import { VTextField } from "vuetify/lib/components/index.mjs";

const props = defineProps({
    inline: { type: Boolean, default: false },
    modelValue: { required: true },
    validation: { type: Object, default: () => ({}) },
});

const emit = defineEmits([
    "update:modelValue",
    "clickAppend",
    "clickAppendInner",
    "clickPrepend",
    "clickPrependInner",
    "keydown",
]);

const inputValue = computed({
    get() {
        return props.modelValue;
    },
    set(value) {
        emit("update:modelValue", value);
    },
});

const v$ = useVuelidate({ inputValue: props.validation }, { inputValue });

const errorMessage = computed(() => {
    if (!v$.value.inputValue.$dirty) return "";
    if (!Array.isArray(v$.value.inputValue.$errors)) return "";

    return v$.value.inputValue.$errors
        .map((error) => error.$message)
        .join(", ");
});

const layout = <VTextField["$props"]>computed(() => {
    if (props.inline) return { density: "compact", hideDetails: true };
});
</script>
