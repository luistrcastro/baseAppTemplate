<template>
    <span v-if="!isEditing" @click="editValue">{{ modelValue }}</span>
    <v-text-field
        v-else
        v-model="inputValue"
        :error-messages="errorMessage"
        append-inner-icon=""
        @blur="v$.inputValue.$touch"
        @click:append="emit('clickAppend')"
        @click:append-inner="emit('clickAppendInner')"
        @click:prepend="emit('clickPrepend')"
        @click:prepend-inner="emit('clickPrependInner')"
        @keydown="emit('keydown', $event)"
    >
        <template #append-inner>
            <v-btn
                class="text-none text-success"
                icon="mdi-check"
                rounded="0"
                size="small"
                style="background-color: transparent"
                variant="flat"
                @click="finishEditing(true)"
            ></v-btn>
            <v-btn
                class="text-none text-error"
                icon="mdi-close"
                rounded="0"
                size="small"
                style="background-color: transparent"
                variant="flat"
                @click="finishEditing(false)"
            ></v-btn>
        </template>
    </v-text-field>
</template>

<script setup lang="ts">
import useVuelidate from "@vuelidate/core";
import deepClone from "~/helpers/deepClone";

const props = defineProps({
    modelValue: { required: true, type: String },
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

const isEditing = ref(false);

const inputValue = ref("");
function editValue() {
    inputValue.value = props.modelValue;
    isEditing.value = true;
}
function finishEditing(submit: boolean) {
    if (submit) emit("update:modelValue", `${inputValue.value}`.trim());
    isEditing.value = false;
}

const v$ = useVuelidate({ inputValue: props.validation }, { inputValue });

const errorMessage = computed(() => {
    if (!v$.value.inputValue.$dirty) return "";
    if (!Array.isArray(v$.value.inputValue.$errors)) return "";

    return v$.value.inputValue.$errors
        .map((error) => error.$message)
        .join(", ");
});
</script>
