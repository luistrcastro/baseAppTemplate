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
        <template #item.date="{ item, value }">
            <basic-date-picker
                :modelValue="value"
                hide-details="auto"
                @update:modelValue="updateValue(item.id, 'date', $event)"
            />
        </template>
        <template #item.str_0="{ item, value }">
            <transactions-str-input
                :modelValue="value"
                @update:model-value="updateValue(item.id, 'str_0', $event)"
            />
        </template>
        <template #item.str_1="{ item, value }">
            <!-- HANDLE CATEGORY SELECT -->
        </template>
    </v-data-table>
    <!-- <v-table v-if="transactionsArray.length" key="table" density="compact">
        <thead>
            <tr>
                <template
                    v-for="label in Object.keys(transactionsArray[0])"
                    :key="label"
                    class="text-left"
                >
                    <th v-if="label !== 'id'">
                        {{ label }}
                    </th>
                </template>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in transactionsArray" :key="index">
                <template v-for="key in Object.keys(item)" :key="key">
                    <td
                        v-if="key !== 'id'"
                        :key="`${item.id}_${key}`"
                        @click="editField(item.id, key)"
                    >
                        <template
                            v-if="
                                updatingField === key &&
                                updatingFieldId === item.id
                            "
                        >
                            <v-text-field
                                v-if="key.includes('value')"
                                v-model="item[key]"
                                density="compact"
                                hide-details="auto"
                                type="number"
                            />
                            <v-text-field
                                v-if="key.includes('str')"
                                v-model="item[key]"
                                density="compact"
                                hide-details="auto"
                            />
                            <basic-date-picker
                                v-if="key.includes('date')"
                                v-model="item[key]"
                                hide-details="auto"
                            />
                        </template>
                        <span v-else>
                            {{ item[key] }}
                        </span>
                    </td>
                </template>
                <td>
                    <div class="d-inline-flex">
                        <v-btn
                            variant="text"
                            :disabled="isSaving"
                            icon="mdi-delete"
                            @click="removeItem(item.id)"
                        >
                            <v-icon
                                color="red"
                                icon="mdi-delete"
                                size="small"
                            />
                        </v-btn>
                        <v-btn
                            variant="text"
                            :disabled="isSaving"
                            icon
                            @click="saveItem(item)"
                        >
                            <v-icon
                                color="blue-darken-2"
                                icon="mdi-content-save"
                                size="small"
                            />
                        </v-btn>
                    </div>
                </td>
            </tr>
        </tbody>
    </v-table> -->
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

function updateValue(id: string | number, key: string, value: string | number) {
    const foundItem = transactionsArray.value.find((e) => e.id === id);
    foundItem[key] = value;
}

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

function formatTransactions(string: string) {
    copiedTransactions.value = string
        .replace(/(?:\n|\r|\t|\f|\v)+/g, "&*&")
        .split("&*&")
        .filter((e) => !!e.trim() && e.trim() !== "");

    let valuesIndexes: number[] = [];
    let transactionLength = -1;
    let firstDateIndex = 0;
    let accumulatedIndex = 0;
    const tmpTransactionsArray = deepClone(copiedTransactions.value);
    let transaction = [];
    let nextTransactionStart = 1;
    do {
        const newArray = tmpTransactionsArray.slice(accumulatedIndex);
        nextTransactionStart = findNextTransactionStart(newArray);
        if (nextTransactionStart < 0) break;
        const newTransaction = buildTransactionObj(
            newArray.slice(0, nextTransactionStart || newArray.length)
        );
        transactionsArray.value.push(newTransaction);
        accumulatedIndex += nextTransactionStart;
    } while (
        accumulatedIndex < tmpTransactionsArray.length &&
        nextTransactionStart > 0
    );
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
        console.log(["SAVE ITEM", response]);
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
        console.log(["SAVE ALL", response]);
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

// UPDATING FIELDS
let updatingField = ref();
let updatingFieldId = ref();

function editField(id, field) {
    console.log("EDIT FIELD", id, field);

    updatingFieldId.value = id;
    updatingField.value = field;
}
</script>

<style scoped></style>
