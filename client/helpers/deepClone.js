export default function deepClone(collection) {
    if (!collection) return collection;
    return JSON.parse(JSON.stringify(collection));
}
