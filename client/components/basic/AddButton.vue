<template>
    <div class="add-button">
        <v-menu>
            <template #activator="{ props }">
                <v-btn color="primary" icon v-bind="props">
                    <v-icon color="white" large>mdi-plus</v-icon>
                </v-btn>
            </template>
            <v-list>
                <v-list-item value="singleTransaction">
                    <template v-slot:prepend>
                        <v-icon icon="mdi-bank-transfer-out"></v-icon>
                    </template>
                    <v-list-item-title>Single Transaction</v-list-item-title>
                </v-list-item>
                <v-list-item value="multipleTransaction">
                    <template v-slot:prepend>
                        <v-icon icon="mdi-bank-transfer"></v-icon>
                    </template>
                    <v-list-item-title>
                        <nuxt-link
                            class="text-decoration-none text-black"
                            :to="{ name: 'import-transactions' }"
                            >Import Transactions</nuxt-link
                        >
                    </v-list-item-title>
                </v-list-item>
                <v-list-item value="category">
                    <template v-slot:prepend>
                        <v-icon icon="mdi-expand-all"></v-icon>
                    </template>
                    <v-list-item-title>
                        <nuxt-link>Category</nuxt-link></v-list-item-title
                    >
                </v-list-item>
                <v-list-item value="account">
                    <template v-slot:prepend>
                        <v-icon icon="mdi-bank"></v-icon>
                    </template>
                    <v-list-item-title>Account</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>
    </div>
</template>

<script setup lang="ts">
import { computed } from "@vue/reactivity";
import { defineProps, defineEmits } from "vue";

const props = defineProps({
    dialog: { type: Boolean, default: false },
});

const emit = defineEmits<{
    (e: "update", value: boolean): void;
}>();

const isDialogActive = computed({
    get() {
        return props.dialog;
    },
    set() {
        emit("update", false);
    },
});
</script>
