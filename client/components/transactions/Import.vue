<template>
    <v-btn @click="clipboard">Paste From Clipboard</v-btn>
    <div
        v-if="transactionsArray.length"
        key="save-all"
        class="my-2 w-100 d-flex justify-space-between"
    >
        <div class="w-100 d-flex pr-2" style="min-width: 400px">
            <v-select
                class="mr-2"
                density="compact"
                hide-details="auto"
                label="Account"
                :items="['Account 1', 'Account 2', 'Account 3']"
            />
            <v-select
                v-model="descriptionKey"
                class="mr-2"
                density="compact"
                hide-details="auto"
                label="Description Field"
                :items="stringFields"
            />
            <v-select
                v-model="valueKey"
                density="compact"
                hide-details="auto"
                label="Value Field"
                :items="valueFields"
            />
        </div>
        <v-btn color="blue-darken-2 mt-2" :disabled="isSaving" @click="saveAll">
            Save All
        </v-btn>
    </div>
    <v-data-table
        v-if="transactionsArray.length"
        key="table"
        :headers="headers"
        :items="transactionsArray"
        item-value="name"
    >
        <template #item.date="{ item }">
            <basic-date-picker v-model="item.date" hide-details="auto" />
        </template>
        <template #item.str_0="{ item, value }">
            <transactions-str-input v-model="item.str_0" />
        </template>
        <template #item.str_1="{ item, value }">
            <!-- HANDLE CATEGORY SELECT -->
        </template>
    </v-data-table>
    <category-unrecognized-dialog
        v-if="isNewCategoriesDialogActive"
        v-model:isDialogActive="isNewCategoriesDialogActive"
        key="unrecognized-categories"
        :categories="unrecognizedCategories"
    />
    <v-bottom-sheet :modelValue="displayNewCategoriesWarning">
        <v-card title="New Categories">
            <div class="d-flex justify-space-between px-4 py-3">
                <span class="ma-2">
                    We identified new categories in the transactions you
                    provided. Would you like to save them?
                </span>
                <div>
                    <v-btn
                        text="Save"
                        color="success"
                        @click="fireNewCategoriesDialog"
                    />
                    <v-btn
                        color="error"
                        text="Cancel"
                        variant="text"
                        @click="displayNewCategoriesWarning = false"
                    />
                </div>
            </div>
        </v-card>
    </v-bottom-sheet>
</template>

<script setup lang="ts">
import dayjs from "dayjs";
import deepClone from "@/helpers/deepClone";
import customParseFormat from "dayjs/plugin/customParseFormat";

const headers = [
    {
        title: "Date",
        align: "start",
        key: "date",
    },
    {
        title: "Description",
        align: "start",
        key: "str_0",
    },
    {
        title: "Category",
        align: "start",
        key: "str_1",
    },
    {
        title: "Value",
        align: "start",
        key: "value_0",
    },
];

const displayNewCategoriesWarning = ref(false);

const categoryStore = useCategoryStore();

const copiedTransactions = ref([]);
let transactionsArray = ref<TransactionObj[]>([]);
let descriptionKey = ref("str_0");
let valueKey = ref("value_0");

async function clipboard() {
    const text = await navigator.clipboard.readText();
    formatTransactions(text);
}

const ignoredValues = ["open dialog"];
let idControl = 1;
let valueIndex = 0;
let strIndex = 0;
const stringFields = computed(() =>
    [...Array(strIndex).keys()].map((i) => `str_${i}`)
);
const valueFields = computed(() =>
    [...Array(valueIndex).keys()].map((i) => `value_${i}`)
);
const unrecognizedCategories = ref([]);
const isNewCategoriesDialogActive = ref(false);

function formatTransactions(string: string) {
    copiedTransactions.value = string
        .replace(/(?:\n|\r|\t|\f|\v)+/g, "&*&")
        .split("&*&")
        .filter((e) => !!e.trim() && e.trim() !== "");

    let accumulatedIndex = 0;
    const tmpTransactionsArray = deepClone(copiedTransactions.value);
    let nextTransactionStart = 1;
    do {
        const newArray = tmpTransactionsArray.slice(accumulatedIndex);
        nextTransactionStart = findNextTransactionStart(newArray);
        if (nextTransactionStart < 0) break;
        transactionsArray.value.push(
            buildTransactionObj(
                newArray.slice(0, nextTransactionStart || newArray.length)
            )
        );
        accumulatedIndex += nextTransactionStart;
    } while (
        accumulatedIndex < tmpTransactionsArray.length &&
        nextTransactionStart > 0
    );

    inferTransactionObjFields();
}

function findNextTransactionStart(array: string[]): number {
    let dateCount = 0;
    let index = -1;

    for (let i = 0; i < array.length; i++) {
        if (isDateLike(array[i])) {
            if (dateCount === 1) {
                index = i;
                break;
            }
            dateCount += 1;
            index = 0;
        }
    }
    return index;
}

function isDateLike(value: string) {
    dayjs.extend(customParseFormat);
    const tmp = value.replace(/[\/\s]+/g, "-");
    return (
        dayjs(tmp, "YYYY-MM-DD", true).isValid() ||
        dayjs(tmp, "DD-MM-YYYY", true).isValid() ||
        dayjs(tmp, "MM-DD-YYYY", true).isValid() ||
        dayjs(tmp, "MMM-DD", true).isValid() ||
        dayjs(tmp, "MMMM-DD", true).isValid() ||
        dayjs(tmp, "DD-MMM", true).isValid() ||
        dayjs(tmp, "DD-MMMM", true).isValid()
    );
}
function isValueLike(value: string) {
    return value.split("$").findIndex((v) => !!parseFloat(v));
}

interface TransactionObj {
    date: string | null;
    id: string | number;
    [key: string]: unknown;
}

function buildTransactionObj(array: string[]) {
    const tmp: TransactionObj = {
        date: null,
        id: 0,
    };

    strIndex = 0;
    valueIndex = 0;
    for (let i = 0; i < array.length; i++) {
        const value = array[i];
        if (isDateLike(value)) {
            tmp.date = dayjs(value).year(dayjs().year()).format("YYYY-MM-DD");
        } else if (isValueLike(value) >= 0) {
            tmp[`value_${valueIndex}`] =
                parseFloat(
                    value
                        .split("$")
                        .find((v) => !!parseFloat(v))
                        .replace(/,/g, "")
                ) * (/[+-]/.test(value) || value[0] === " " ? 1 : -1);
            // In Tangerine for example, + or - are not selected, leaving a white space
            valueIndex += 1;
        } else if (!ignoredValues.includes(value)) {
            tmp[`str_${strIndex}`] = value;
            strIndex += 1;
        }
    }
    tmp.id = `fakeId${idControl}`;
    tmp.account_id = 1; // TODO: Link account to user's input
    idControl += 1;
    return tmp;
}

function inferTransactionObjFields() {
    let probableCategoryField: string | null = null;
    let probableDescriptionField: string = "";

    let largestObj = transactionsArray.value[0];
    transactionsArray.value.forEach((e) => {
        if (Object.keys(e).length > Object.keys(largestObj).length)
            largestObj = e;
    });
    const strKeys = Object.keys(largestObj).filter((e) => e.includes("str"));

    for (const [i, t] of transactionsArray.value.entries()) {
        for (const key of strKeys) {
            if (
                !probableCategoryField &&
                categoryStore.index.some(
                    (c) =>
                        c.name
                            .toLowerCase()
                            .includes(`${t[key]}`.toLowerCase()) ||
                        `${t[key]}`.toLowerCase().includes(c.name.toLowerCase())
                )
            ) {
                probableCategoryField = key;
            }

            if (
                `${t[key]}`.length >
                `${t[probableDescriptionField] || ""}`.length
            )
                probableDescriptionField = key;
        }
        if (i > 10) break;
    }

    if (
        !probableCategoryField ||
        !probableDescriptionField ||
        probableCategoryField === probableDescriptionField
    )
        return;
    mapFields(probableCategoryField, probableDescriptionField);
    mapUncategorizedExpenses(probableCategoryField);

    // if (strKeys.length === 2) {
    //     probableDescriptionField = strKeys.filter(
    //         (e) => e !== probableCategoryField
    //     )[0];
    //     mapFields(probableCategoryField, probableDescriptionField);
    //     return;
    // }
}

function mapFields(categoryKey: string, descriptionKey: string) {
    transactionsArray.value = transactionsArray.value.map((e) => ({
        ...e,
        category_id:
            categoryStore.index.find(
                (c) => c.name.toLowerCase() === e[categoryKey].toLowerCase()
            )?.id || null,
        description: e[descriptionKey],
    }));
}

function mapUncategorizedExpenses(categoryField: string) {
    transactionsArray.value.forEach((e) => {
        if (!e.category_id) unrecognizedCategories.value.push(e[categoryField]);
    });
    unrecognizedCategories.value = [...new Set(unrecognizedCategories.value)];
    if (unrecognizedCategories.value.length)
        displayNewCategoriesWarning.value = true;
}

function fireNewCategoriesDialog() {
    displayNewCategoriesWarning.value = false;
    isNewCategoriesDialogActive.value = true;
}

/**
 *
 * Requests Functions
 *
 */
let isSaving = ref(false);
function removeItem(id: string) {
    transactionsArray = transactionsArray.value.filter((e) => e.id !== id);
}
async function saveItem(item: { id: string }) {
    try {
        isSaving.value = true;
        const response = await $larafetch("/api/transactions", {
            method: "post",
            body: {
                ...item,
                value: item[valueKey],
                description: item[descriptionKey],
            },
        });
        useSnackbarStore().SHOW_MESSAGE({
            content: "Transaction Saved",
            color: "success",
            timeout: 3000,
        });
        removeItem(item.id);
        // TODO handle response - probably send it to transactions store
    } catch (error) {
        useSnackbarStore().SHOW_MESSAGE({
            content: `${error}`,
            color: "error",
            timeout: 3000,
        });
    } finally {
        isSaving.value = false;
    }
}
async function saveAll() {
    try {
        isSaving.value = true;
        const response = await $larafetch("/api/transactions/bulk", {
            method: "post",
            body: {
                transactions: transactionsArray.value.map((item) => ({
                    ...item,
                    value: item[valueKey],
                    description: item[descriptionKey],
                })),
            },
        });
        transactionsArray.value = [];
        useSnackbarStore().SHOW_MESSAGE({
            content: "Transactions Saved",
            color: "success",
            timeout: 3000,
        });
        // TODO handle response - probably send it to transactions store
    } catch (error) {
        useSnackbarStore().SHOW_MESSAGE({
            content: `${error}`,
            color: "error",
            timeout: 3000,
        });
    } finally {
        isSaving.value = false;
    }
}
</script>

<style scoped></style>
