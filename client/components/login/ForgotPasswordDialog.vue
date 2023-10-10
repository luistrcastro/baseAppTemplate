<template>
    <v-dialog
        v-model="dialog"
        overlay-color="black"
        overlay-opacity="0.7"
        max-width="600px"
        @update:dialog="closeDialog"
    >
        <v-card>
            <v-card-title>
                <span class="text-h5">Type in your email</span>
            </v-card-title>
            <form @submit.prevent="submit">
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12">
                                Forgot your password? No problem. Just let us
                                know your email address and we will email you a
                                password reset link that will allow you to
                                choose a new one.
                                <BasicInputField
                                    v-model="emailInput"
                                    :disabled="inProgress"
                                    label="Email*"
                                    :validation="rules.email"
                                    @keydown="listenToEnter"
                                />
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-btn
                        color="primary"
                        :disabled="inProgress"
                        :loading="inProgress"
                        type="submit"
                    >
                        Submit
                    </v-btn>
                    <v-btn
                        color="error"
                        :disabled="inProgress"
                        :loading="inProgress"
                        @click="closeDialog"
                    >
                        Close
                    </v-btn>
                </v-card-actions>
            </form>
        </v-card>
    </v-dialog>
</template>

<script setup lang="ts">
import useVuelidate from "@vuelidate/core";
import { required, email, helpers } from "@vuelidate/validators";

const props = defineProps({
    email: { type: String, default: null },
});
const emit = defineEmits(["update:email", "update:isDialogActive"]);

const { forgotPassword } = useAuth();

const dialog = true;
const emailInput = computed({
    get() {
        return props.email;
    },
    set(value) {
        emit("update:email", value);
    },
});
const rules = computed(() => {
    return {
        email: {
            required: helpers.withMessage(
                "The email field is required",
                required
            ),
            email: helpers.withMessage("Invalid email format", email),
        },
    };
});

const v$ = useVuelidate();
const snackbarStore = useSnackbarStore();
const {
    submit,
    inProgress,
    validationErrors: errors,
} = useSubmit(
    async () => {
        if (!(await v$.value.$validate())) {
            return Error("Invalid inputs");
        }
        return forgotPassword(emailInput.value);
    },
    {
        onSuccess: (result) => {
            if (result?.message === "Invalid inputs") {
                console.log("INVALID INPUTS");
                return;
            }
            snackbarStore.SHOW_MESSAGE({
                content: "Email sent",
                color: "success",
                timeout: 3000,
            });
            closeDialog();
        },
        onError: (error) => {
            console.log(["ERROR", error]);
        },
    }
);

function listenToEnter(key: string) {
    if (key === "Enter") submit();
}

function closeDialog() {
    emit("update:isDialogActive", false);
}
</script>
