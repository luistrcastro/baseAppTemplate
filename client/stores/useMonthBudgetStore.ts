import { IMonthBudget } from "~/contracts/stores/MonthBudget";
import { upsertById } from "~/helpers/upsertById";
import { sortByKey } from "~/helpers/sortByKey";

interface Response {
    data: IMonthBudget[];
}
const resourceUrl = "month_budgets";
const sortKey = "name";

const template = defineStore("monthBudgetStore", {
    state: () => ({
        baseBudgets: <IMonthBudget[]>[],
        index: <IMonthBudget[]>[],
        storeReady: <boolean>false,
        url: `/api/${resourceUrl}`,
    }),

    actions: {
        async getBaseResource() {
            try {
                this.storeReady = false;
                const response: Response = await $larafetch(
                    `/api/base_${resourceUrl}`,
                    {
                        method: "get",
                    }
                );
                this.baseBudgets = sortByKey(response.data, sortKey);
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
                this.index = sortByKey(response.data, sortKey);
                this.storeReady = true;
            } catch (error) {
                // TODO handle error
                console.log([error]);
            }
        },
        addItem(item: Object) {
            return new Promise(async (resolve, reject) => {
                try {
                    const response: IMonthBudget = await $larafetch(this.url, {
                        method: "post",
                        body: item,
                    });
                    this.index = sortByKey(
                        [...this.index, response.data],
                        sortKey
                    );
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
                    this.index = sortByKey(
                        upsertById(this.index, response.data),
                        sortKey
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
        sortCategories(data: IMonthBudget[]) {
            return data.sort((a, b) =>
                (a.name || "") > (b.name || "") ? 1 : -1
            );
        },
    },

    getters: {
        getById:
            ({ index }) =>
            (id: number | null) => {
                return id ? index.find((b) => b.id === id) : null;
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
