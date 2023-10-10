<template>
    <!-- <v-btn variant="text" @click="showPicker = true"
            >{{ inputValue }}

            <v-tooltip v-model="showPicker" location="right">
                <template v-slot:activator="{ props }">
                    <span v-bind="props"></span>
                </template>
                <v-date-picker
                    v-if="showPicker"
                    v-model="inputValue"
                    @update:model-value="showPicker = false"
                ></v-date-picker>
            </v-tooltip>
        </v-btn> -->
    <v-menu location="end">
        <template v-slot:activator="{ props }">
            <v-btn v-bind="props" variant="text">
                {{ inputValue }}
            </v-btn>
        </template>
        <v-list
            class="pa-0 ma-0"
            style="width: fit-content; height: fit-content"
        >
            <v-date-picker
                v-model="inputValue"
                format="YYYY-MM-DD"
                hide-actions
                reactive
            ></v-date-picker>
        </v-list>
    </v-menu>
</template>

<script setup lang="ts">
import useVuelidate from "@vuelidate/core";
import dayjs from "dayjs";

const props = defineProps({
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
        return dayjs(props.modelValue).format("YYYY-MM-DD");
    },
    set(value) {
        emit("update:modelValue", dayjs(value).format("YYYY-MM-DD"));
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
</script>

<style scoped></style>
