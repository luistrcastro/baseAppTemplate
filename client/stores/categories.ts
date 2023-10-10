import { upsertById } from "~/helpers/upsertById";

interface GenericObject {
    id: number | string;
    [key: string]: any;
}
interface Response {
    data: GenericObject[];
}

export const useCategoryStore = defineStore("categoryStore", {
    state: () => ({
        baseCategories: <Object[]>[],
        index: <Object[]>[],
        storeReady: <boolean>false,
        url: "/api/categories",
    }),

    actions: {
        async getBaseCategories() {
            try {
                this.storeReady = false;
                const response: Response = await $larafetch(
                    "/api/base_categories",
                    {
                        method: "get",
                    }
                );
                this.baseCategories = response.data;
            } catch (error) {
                // TODO handle error
                console.log([error]);
            }
        },
        async getData() {
            try {
                this.storeReady = false;
                const response: Response = await $larafetch(this.url, {
                    method: "get",
                });
                this.index = response.data;
                this.storeReady = true;
            } catch (error) {
                // TODO handle error
                console.log([error]);
            }
        },
        addItem(item: Object) {
            return new Promise(async (resolve, reject) => {
                try {
                    const response: Response = await $larafetch(this.url, {
                        method: "post",
                        body: item,
                    });
                    this.index.unshift(response.data);
                    return resolve;
                } catch (error) {
                    // TODO handle error
                    console.log([error]);
                    return reject(error);
                }
            });
        },
        updateItem(item: { id: number }) {
            return new Promise(async (resolve, reject) => {
                try {
                    const response: Response = await $larafetch(
                        `${this.url}/${item.id}`,
                        {
                            method: "update",
                            body: item,
                        }
                    );
                    this.index = upsertById(this.index, response.data);
                    return resolve;
                } catch (error) {
                    // TODO handle error
                    console.log([error]);
                    return reject(error);
                }
            });
        },
        deleteItem(id: number) {
            return new Promise(async (resolve, reject) => {
                try {
                    await $larafetch(`${this.url}/${id}`, {
                        method: "delete",
                    });
                    this.index = this.index.filter((e: any) => e.id !== id);
                    return resolve;
                } catch (error) {
                    // TODO handle error
                    console.log([error]);
                    return reject(error);
                }
            });
        },
    },
});
