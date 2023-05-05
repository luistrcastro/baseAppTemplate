<template>
	<div>Main page!</div>
	<v-btn @click="refresh">fetch </v-btn>
	<v-btn @click="create">create </v-btn>
	<v-btn @click="update">update </v-btn>
	<v-btn @click="deleteItem">delete </v-btn>
	<v-btn @click="restore">restore </v-btn>

	<!-- You use the default slot to render your content -->
	<!-- <NuxtErrorBoundary @error="errorLogger">
		<template #error="{ error }">
			{{ error }}
			You can display the error locally here.
			<button @click="error = null">This will clear the error.</button>
		</template>
	</NuxtErrorBoundary> -->
</template>

<script setup lang="ts">
	definePageMeta({
		title: 'Home',
		middleware: ['verified'],
	});

	// function errorLogger() {}

	const restoredObj = ref();
	const id = ref('1');

	const { data: obj, refresh } = await useAsyncData(
		'accounts',
		() => $larafetch(`/api/accounts/${id.value}`),
		{ watch: [id] }
	);

	const { data: allData, refresh: refreshAllData } = await useAsyncData(
		'accounts',
		() => $larafetch(`/api/accounts`)
	);

	const account = {
		description: 'cupiditate cum consequuntur dolor sit molestiae',
		institution: 'scotia',
		label: 'repellat',
		last_four: 1234,
	};
	const {
		submit: create,
		inProgress,
		validationErrors,
	} = useSubmit(
		() => $larafetch('/api/accounts', { method: 'post', body: account }),
		{
			onSuccess: (result) =>
				console.log('Account created successfully', result),
		}
	);

	const {
		submit: deleteItem,
		inProgress: deleteInProgress,
		validationErrors: deleteValidationErrors,
	} = useSubmit(
		() => $larafetch(`/api/accounts/${id.value}`, { method: 'delete' }),
		{
			onSuccess: (result) =>
				console.log('Account deleted successfully', result),
		}
	);

	const {
		submit: update,
		inProgress: updateInProgress,
		validationErrors: updateValidationErrors,
	} = useSubmit(
		() =>
			$larafetch(`/api/accounts/${id.value}`, {
				method: 'update',
				body: account,
			}),
		{
			onSuccess: (result) =>
				console.log('Account created successfully', result),
		}
	);

	const {
		submit: restore,
		inProgress: restoreInProgress,
		validationErrors: restoreValidationErrors,
	} = useSubmit(
		() => $larafetch(`/api/categories/restore/925830557`, { method: 'post' }),
		{
			onSuccess: (result) => {
				console.log('Account restored successfully', result);
				restoredObj.value = result;
			},
		}
	);
</script>
