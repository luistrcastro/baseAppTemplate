/**
 * Converts a string into title case.
 */

export default function titleCase(value) {
    if (!value) {
        return value;
    }

    return value
        .replace(/[_\-.]/g, " ")
        .replace(
            /\w\S*/g,
            (t) => t.charAt(0).toUpperCase() + t.substr(1).toLowerCase()
        );
}
