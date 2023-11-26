export function sortByKey(resource, key) {
    return resource.sort((a, b) => ((a[key] || "") > (b[key] || "") ? 1 : -1));
}
