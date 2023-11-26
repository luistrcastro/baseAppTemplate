import { mergeProps } from 'nuxt/dist/app/compat/capi';
<template>
    <v-chip
        v-if="currentBudget"
        key="month-budget"
        class="ma-2"
        :color="currentBudget.type === 'income' ? 'success' : 'error'"
        variant="outlined"
    >
        <v-icon start icon="mdi-server-plus"></v-icon>
        {{ currentBudget.name }}
    </v-chip>
    <v-select
        v-else
        key="budget-select"
        v-model="inputValue"
        clearable
        :items="budgets"
        item-value="id"
        item-title="name"
        label="Month Budget"
        :disabled="readonly"
        :readonly="readonly"
        v-bind="layout"
    ></v-select>
</template>

<script setup lang="ts">
import { VSelect } from "vuetify/lib/components/index.mjs";
const emit = defineEmits(["update:modelValue"]);

interface Props {
    inline?: boolean;
    modelValue: number | null;
    categoryId: number | null;
    readonly: boolean;
}
const props = withDefaults(defineProps<Props>(), {
    inline: false,
    readonly: false,
});

const inputValue = computed({
    get() {
        return props.modelValue;
    },
    set(value) {
        emit("update:modelValue", value);
    },
});

const monthBudgetStore = useMonthBudgetStore();
const budgets = computed(() => monthBudgetStore.index);
const currentBudget = computed(() =>
    topCategory.value
        ? monthBudgetStore.getById(topCategory.value.month_budget_id)
        : null
);

const topCategory = computed(() => {
    if (props.categoryId)
        return useCategoryStore().getTopParent(props.categoryId);
});
// TODO if the top category has a month budget, set this as readonly and get the month budget id
// otherwise, leave it editable

const layout = <VSelect["$props"]>computed(() => {
    if (props.inline) return { density: "compact", hideDetails: true };
});
</script>
