<template>
	<div>
		Thanks for signing up! Before getting started, could you verify your email
		address by clicking on the link we just emailed to you? If you didn't
		receive the email, we will gladly send you another.
	</div>

	<template v-if="verificationIsSent">
		<div>
			A new verification link has been sent to the email address you provided
			during registration.
		</div>
	</template>

	<div>
		<v-btn @click="handleResendVerification" :disabled="verificationIsSent">
			Resend Verification Email
		</v-btn>

		<v-btn @click="logout"> Logout </v-btn>
	</div>
</template>

<script setup lang="ts">
	definePageMeta({ middleware: ['unverified'] });

	const { logout, resendEmailVerification } = useAuth();
	const verificationIsSent = ref(false);

	async function handleResendVerification() {
		const status = (await resendEmailVerification()).status;
		if (status === 'verification-link-sent') {
			verificationIsSent.value = true;
		}
	}
</script>
