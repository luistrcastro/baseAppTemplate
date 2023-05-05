<template>
	<v-btn plain @click="dialog = true"> Forgot your password? </v-btn>
	<v-dialog
		v-model="dialog"
		overlay-color="black"
		overlay-opacity="0.7"
		max-width="600px"
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
								Forgot your password? No problem. Just let us know your email
								address and we will email you a password reset link that will
								allow you to choose a new one.
								<BasicInputField
									v-model="emailInput"
									:disabled="resetEmailSent"
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
						:disabled="inProgress || resetEmailSent"
						:loading="inProgress"
						type="submit"
					>
						Submit
					</v-btn>
				</v-card-actions>
			</form>
		</v-card>
	</v-dialog>
</template>

<script setup lang="ts">
	import useVuelidate from '@vuelidate/core';
	import { required, email, helpers } from '@vuelidate/validators';

	const { forgotPassword } = useAuth();

	const dialog = ref(false);
	const emailInput = ref('');
	const resetEmailSent = ref(false);
	const rules = computed(() => {
		return {
			email: {
				required: helpers.withMessage('The email field is required', required),
				email: helpers.withMessage('Invalid email format', email),
			},
		};
	});

	const v$ = useVuelidate();

	const {
		submit,
		inProgress,
		validationErrors: errors,
	} = useSubmit(
		async () => {
			if (!(await v$.value.$validate())) {
				return Error('Invalid inputs');
			}
			return forgotPassword(emailInput.value);
		},
		{
			onSuccess: (result) => {
				if (result?.message === 'Invalid inputs') {
					console.log('INVALID INPUTS');
					return;
				}
				resetEmailSent.value = true;
			},
			onError: (error) => {
				console.log(['ERROR', error]);
			},
		}
	);

	function listenToEnter(key: string) {
		if (key === 'Enter') submit();
	}
</script>
