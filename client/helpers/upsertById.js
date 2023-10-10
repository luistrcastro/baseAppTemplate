/**
 * Traditional upsert function by item's id
 * @param resource
 * @param item
 * @returns {any}
 */
export function upsertById(resource, item) {
    const tmp = deepClone(resource);
    const foundIndex = resource.findIndex((e) => e.id === item.id);
    if (foundIndex < 0) tmp.unshift(item);
    else tmp.splice(foundIndex, 1, item);
    return tmp;
}
