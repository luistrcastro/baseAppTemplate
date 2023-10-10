export default function objectHasKey(object, key) {
    return Object.prototype.hasOwnProperty.call(object, key);
}
