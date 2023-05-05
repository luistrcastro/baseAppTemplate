export interface ISnackbarState {
	color: string;
	content: string;
	position: string;
	timeout: number;
	[key: string]: unknown;
}
