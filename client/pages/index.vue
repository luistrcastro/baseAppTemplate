<template>
    <!-- You use the default slot to render your content -->
    <!-- <NuxtErrorBoundary @error="errorLogger">
    <template #error="{ error }">
      {{ error }}
			You can display the error locally here.
			<button @click="error = null">This will clear the error.</button>
		</template>
	</NuxtErrorBoundary> -->
    <basic-add-button />
</template>

<script setup lang="ts">
definePageMeta({
    title: "Home",
    middleware: ["verified"],
    name: "home",
    template: "default",
});

const restoredObj = ref();
const id = ref("1");

const { data: allData, refresh: refreshAllData } = await useAsyncData(
    "accounts",
    () => $larafetch(`/api/accounts`)
);

const account = {
    description: "cupiditate cum consequuntur dolor sit molestiae",
    institution: "scotia",
    label: "repellat",
    last_four: 1234,
};
const {
    submit: create,
    inProgress,
    validationErrors,
} = useSubmit(
    () => $larafetch("/api/accounts", { method: "post", body: account }),
    {
        onSuccess: (result) =>
            console.log("Account created successfully", result),
    }
);

const {
    submit: deleteItem,
    inProgress: deleteInProgress,
    validationErrors: deleteValidationErrors,
} = useSubmit(
    () => $larafetch(`/api/accounts/${id.value}`, { method: "delete" }),
    {
        onSuccess: (result) =>
            console.log("Account deleted successfully", result),
    }
);

const {
    submit: update,
    inProgress: updateInProgress,
    validationErrors: updateValidationErrors,
} = useSubmit(
    () =>
        $larafetch(`/api/accounts/${id.value}`, {
            method: "update",
            body: account,
        }),
    {
        onSuccess: (result) =>
            console.log("Account created successfully", result),
    }
);

const {
    submit: restore,
    inProgress: restoreInProgress,
    validationErrors: restoreValidationErrors,
} = useSubmit(
    () => $larafetch(`/api/categories/restore/925830557`, { method: "post" }),
    {
        onSuccess: (result) => {
            console.log("Account restored successfully", result);
            restoredObj.value = result;
        },
    }
);
</script>
