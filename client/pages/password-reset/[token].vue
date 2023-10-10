<template>
    <v-layout fill-height class="justify-center">
        <v-col cols="6" align-self="center">
            <v-card>
                <form @submit.prevent="submit">
                    <v-card-title class="text-h5 d-flex align-center">
                        <v-img
                            class="mr-2"
                            contain
                            height="35"
                            max-width="35"
                            src="/img/png/CAD-coin.png"
                        />
                        <span> Toonie </span>
                    </v-card-title>
                    <v-card-text class="card-content p-6">
                        <BasicInputField
                            v-model="data.email"
                            disabled
                            label="Email"
                        />
                        <BasicInputField
                            v-model="data.password"
                            :append-icon="
                                showPassword ? 'mdi-eye' : 'mdi-eye-off'
                            "
                            counter
                            hint="At least 8 characters"
                            label="Password"
                            :validation="rules.password"
                            :type="showPassword ? 'text' : 'password'"
                            @click:append="showPassword = !showPassword"
                        />
                        <BasicInputField
                            v-model="data.password_confirmation"
                            :append-icon="
                                showPassword ? 'mdi-eye' : 'mdi-eye-off'
                            "
                            counter
                            hint="At least 8 characters"
                            label="Password"
                            :validation="rules.password"
                            :type="showPassword ? 'text' : 'password'"
                            @click:append="showPassword = !showPassword"
                        />
                    </v-card-text>
                    <v-card-actions>
                        <v-btn
                            color="primary-dark"
                            :disabled="inProgress"
                            :loading="inProgress"
                            type="submit"
                        >
                            Submit
                        </v-btn>
                    </v-card-actions>
                </form>
            </v-card>
        </v-col>
    </v-layout>
</template>

<script setup lang="ts">
import useVuelidate from "@vuelidate/core";
import { helpers, required, email, minLength } from "@vuelidate/validators";

definePageMeta({
    title: "Reset Password",
    layout: "guest",
    middleware: ["guest"],
    name: "resetPassword",
    auth: {
        unauthenticatedOnly: true,
        navigateAuthenticatedTo: "/",
    },
});

const router = useRouter();
const route = useRoute();
const { resetPassword } = useAuth();

if (!route.query.email) {
    router.push("/");
}

const data = reactive({
    email: route.query.email as string,
    password: "",
    password_confirmation: "",
});

const rules = computed(() => {
    return {
        password: {
            required: helpers.withMessage(
                "The password field is required",
                required
            ),
            minLength: minLength(8),
        },
        password_confirmation: {
            required: helpers.withMessage(
                "The password confirmation field is required",
                required
            ),
            minLength: minLength(8),
        },
    };
});
const v$ = useVuelidate();

const snackbarStore = useSnackbarStore();
const token = computed(() => route.params.token);
const {
    submit,
    inProgress,
    validationErrors: errors,
} = useSubmit(
    async () => {
        if (!(await v$.value.$validate())) {
            snackbarStore.SHOW_MESSAGE({
                content: "Invalid credentials",
                color: "error",
                timeout: 3000,
            });
            return;
        }
        resetPassword({ token: token.value as string, ...data });
    },
    {
        onSuccess: (result) =>
            router.push({
                path: "/login",
                query: { reset: btoa(result?.status ?? "") },
            }),
    }
);
</script>
