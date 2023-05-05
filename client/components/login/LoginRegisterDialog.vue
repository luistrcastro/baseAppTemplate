<template>
	<v-btn plain @click="dialog = true"> Register </v-btn>
	<v-dialog
		v-model="dialog"
		overlay-color="black"
		overlay-opacity="0.7"
		max-width="600px"
	>
		<v-card>
			<v-card-title>
				<span class="text-h5">User Profile</span>
			</v-card-title>
			<form @submit.prevent="submit">
				<v-card-text>
					<v-container>
						<v-row>
							<v-col cols="12" sm="6" md="4">
								<BasicInputField
									v-model="userDetails.first_name"
									label="First name*"
									:validation="rules.first_name"
								/>
							</v-col>
							<v-col cols="12" sm="6" md="4">
								<BasicInputField
									v-model="userDetails.middle_name"
									label="Middle name"
								/>
							</v-col>
							<v-col cols="12" sm="6" md="4">
								<BasicInputField
									v-model="userDetails.last_name"
									label="Last name*"
									:validation="rules.last_name"
								/>
							</v-col>
							<v-col cols="12">
								<BasicInputField
									v-model="userDetails.email"
									label="Email*"
									:validation="rules.email"
								/>
							</v-col>
							<v-col cols="12">
								<BasicInputField
									v-model="userDetails.password"
									:append-inner-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
									counter
									hint="At least 8 characters"
									label="Password*"
									:validation="rules.password"
									:type="showPassword ? 'text' : 'password'"
									@click:append-inner="showPassword = !showPassword"
								/>
							</v-col>
							<v-col cols="12">
								<v-text-field
									v-model="userDetails.password_confirmation"
									:append-inner-icon="
										showPasswordConfirmation ? 'mdi-eye' : 'mdi-eye-off'
									"
									counter
									:error-messages="errorMessage"
									hint="At least 8 characters"
									label="Password Confirmation*"
									:validation="rules.password_confirmation"
									:type="showPasswordConfirmation ? 'text' : 'password'"
									@click:append-inner="
										showPasswordConfirmation = !showPasswordConfirmation
									"
								/>
							</v-col>
							<v-col cols="12" sm="6">
								<v-switch
									v-model="userDetails.receives_browser_notifications"
									label="Receive browser notifications"
									color="success"
									default="true"
								/>
								<v-switch
									v-model="userDetails.receives_email_notifications"
									label="Receive email notifications"
									color="success"
								/>
							</v-col>
						</v-row>
					</v-container>
					<small>*indicates required field</small>
				</v-card-text>
				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn
						color="grey"
						:disabled="inProgress"
						:loading="inProgress"
						text
						@click="dialog = false"
					>
						Close
					</v-btn>
					<v-btn
						color="blue darken-1"
						:disabled="inProgress"
						:loading="inProgress"
						text
						type="submit"
					>
						Save
					</v-btn>
				</v-card-actions>
			</form>
		</v-card>
	</v-dialog>
</template>

<script setup lang="ts">
	import {
		required,
		email,
		minLength,
		helpers,
		sameAs,
	} from '@vuelidate/validators';
	import { useVuelidate } from '@vuelidate/core';

	const router = useRouter();
	const { register } = useAuth();

	const dialog = ref(false);
	const showPassword = ref(false);
	const showPasswordConfirmation = ref(false);
	const userDetails = reactive({
		first_name: '',
		middle_name: '',
		last_name: '',
		email: '',
		password: '',
		password_confirmation: '',
		receives_browser_notifications: true,
		receives_email_notifications: true,
		picture_url: null,
	});

	const rules = computed(() => {
		return {
			first_name: {
				required: helpers.withMessage(
					'The First Name field is required',
					required
				),
			},
			last_name: {
				required: helpers.withMessage(
					'The Last Name field is required',
					required
				),
			},
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
			password_confirmation: {
				required: helpers.withMessage(
					'The password confirmation field is required',
					required
				),
				sameAs: helpers.withMessage(
					"Passwords don't match",
					sameAs(userDetails.password)
				),
			},
		};
	});
	const v$ = useVuelidate({ userDetails: rules }, { userDetails });

	const errorMessage = computed(() => {
		if (!v$.value.userDetails.password_confirmation.$dirty) return '';
		if (!Array.isArray(v$.value.userDetails.password_confirmation.$errors))
			return '';

		return v$.value.userDetails.password_confirmation.$errors
			.map((error: { $message: string }) => error.$message)
			.join(', ');
	});

	const {
		submit,
		inProgress,
		validationErrors: errors,
	} = useSubmit(
		async () => {
			if (!(await v$.value.$validate())) {
				console.log('INVALID');
				return;
			}
			return register(userDetails);
		},
		{
			onSuccess: () => router.push('/'),
		}
	);
</script>
