import { upsertById } from '~/helpers/upsertById';

interface GenericObject {
    id: number | string;
    [key: string]: any;
}
interface Response {
    data: GenericObject[];
}

export default function createStore(name: string, url: string) {
    return defineStore(name, {
        state: () => ({
            index: <Object[]>[],
            storeReady: <boolean>false,
        }),

        actions: {
            async getData() {
                try {
                    this.storeReady = false;
                    const response: Response = await $larafetch(url, {
                        method: "index",
                    });
                    this.index = response.data;
                    this.storeReady = true;
                } catch (error) {
                    // TODO handle error
                    console.log([error]);
                }
            },
            async addItem(item: Object) {
                try {
                    const response: Response = await $larafetch(url, {
                        method: "post",
                        body: item,
                    });
                    this.index.unshift(response.data);
                } catch (error) {
                    // TODO handle error
                    console.log([error]);
                }
            },
            async updateItem(item: { id: number }) {
                try {
                    const response: Response = await $larafetch(
                        `${url}/${item.id}`,
                        {
                            method: "update",
                            body: item,
                        }
                    );
                    this.index = upsertById(this.index, response.data)
                } catch (error) {
                    // TODO handle error
                    console.log([error]);
                }
            },
            async deleteItem(id: number) {
              try {
                await $larafetch(
                    `${url}/${id}`,
                    {
                        method: "delete",
                    }
                );
                this.index = this.index.filter((e:any) => e.id !== id)
            } catch (error) {
                // TODO handle error
                console.log([error]);
            }
            },
        },
    });
}
