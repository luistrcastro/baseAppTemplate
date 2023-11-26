import { ICategory } from "~/contracts/stores/Category";
import { upsertById } from "~/helpers/upsertById";

interface Response {
    data: ICategory[];
}

const template = defineStore("categoryStore", {
    state: () => ({
        baseCategories: <ICategory[]>[],
        index: <ICategory[]>[],
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
                this.baseCategories = this.sortCategories(response.data);
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
                this.index = this.sortCategories(response.data);
                this.storeReady = true;
            } catch (error) {
                // TODO handle error
                console.log([error]);
            }
        },
        addItem(item: Object) {
            return new Promise(async (resolve, reject) => {
                try {
                    const response: ICategory = await $larafetch(this.url, {
                        method: "post",
                        body: item,
                    });
                    this.index = this.sortCategories([
                        ...this.index,
                        response.data,
                    ]);
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
                    this.index = this.sortCategories(
                        upsertById(this.index, response.data)
                    );
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
        sortCategories(data: ICategory[]) {
            return data.sort((a, b) =>
                (a.name || "") > (b.name || "") ? 1 : -1
            );
        },
    },

    getters: {
        getById:
            ({ index }) =>
            (id: number) =>
                index.find((c) => c.id === id),
        getTopParent: ({ index }) => {
            const findParent = (
                category: ICategory | undefined
            ): ICategory | undefined =>
                category && category.parent_category_id
                    ? findParent(
                          index.find(
                              (c) => c.id === category.parent_category_id
                          )
                      )
                    : category;

            return (id: number) => findParent(index.find((c) => c.id === id));
        },
        getNotHidden({ index }) {
            return index.filter((e) => !e.is_hidden);
        },
        filterOutChildren({ index }) {
            return index.filter((e) => !e.parent_category_id);
        },
    },
});

export default () => {
    const store = template();
    if (!store.storeReady) {
        store.getData();
    }
    return store;
};
