<template>
	<v-snackbar v-model="show" v-bind="snackbarObj">
		{{ message }}
		<template #actions>
			<v-btn color="white" variant="text" @click="show = false">
				<v-icon>mdi-close</v-icon>
			</v-btn>
		</template>
	</v-snackbar>
</template>

<script setup lang="ts">
	import { useSnackbarStore } from '@/stores/snackbar';

	const message = ref('');
	const show = ref(false);

	let snackbarObj = reactive({});
	onBeforeMount(() => {
		const snackbarStore = useSnackbarStore();
		snackbarStore.$subscribe((mutation, { snackbar }) => {
			// if (mutation.type === 'snackbar/SHOW_MESSAGE') {
			snackbarObj = snackbar;
			message.value = snackbar.content;
			show.value = true;
			// resetPosition();
			// }
		});
	});

	// function resetPosition() {
	// 	setTimeout(() => {
	// 		position.value = '';
	// 		left.value = false;
	// 		right.value = false;
	// 	}, timeout.value + 500);
	// }
</script>
