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
							v-model="guest.email"
							label="Email"
							:validation="rules.email"
						/>
						<BasicInputField
							v-model="guest.password"
							:append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
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
						<LoginForgotPasswordDialog />
						<LoginRegisterDialog />
					</v-card-actions>
				</form>
			</v-card>
		</v-col>
	</v-layout>
</template>

<script setup lang="ts">
	import { required, email, minLength, helpers } from '@vuelidate/validators';
	import { useVuelidate } from '@vuelidate/core';

	definePageMeta({
		title: 'Login',
		layout: 'guest',
		middleware: ['guest'],
		name: 'login',
		auth: {
			unauthenticatedOnly: true,
			navigateAuthenticatedTo: '/',
		},
	});

	const router = useRouter();
	const route = useRoute();
	const { login } = useAuth();

	const showPassword = ref(false);
	const guest = reactive({
		email: '',
		password: '',
		remember: false,
	});
	const status = ref(
		(route.query.reset ?? '').length > 0
			? atob(route.query.reset as string)
			: ''
	);

	const rules = computed(() => {
		return {
			email: {
				required: helpers.withMessage('The email field is required', required),
				email: helpers.withMessage('Invalid email format', email),
			},
			password: {
				required: helpers.withMessage(
					'The password field is required',
					required
				),
				minLength: minLength(8),
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
				snackbarStore.SHOW_MESSAGE({
					content: 'Invalid credentials',
					color: 'error',
					timeout: 3000,
				});
				return;
			}
			status.value = '';
			return login(guest);
		},
		{
			onSuccess: () => router.push('/'),
		}
	);
</script>
