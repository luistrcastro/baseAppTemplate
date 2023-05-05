import { defineStore } from 'pinia';
import { ISnackbarState } from '~/contracts/stores/Snackbar';

export const useSnackbarStore = defineStore('snackbar', {
	state: () => ({
		snackbar: <ISnackbarState>{},
	}),

	actions: {
		SHOW_MESSAGE(payload: {
			content: string;
			position?: string;
			color?: string;
			timeout?: number;
			[key: string]: unknown;
		}) {
			const tmp = payload;
			tmp.content = payload.content;
			tmp.color = payload.color || 'success';
			tmp.position = payload.position || 'bottom';
			tmp.timeout = payload.timeout || 3000;
			this.snackbar = tmp;
		},
	},
});
