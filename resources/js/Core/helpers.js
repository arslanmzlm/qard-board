export function formatDateToLocale(value) {
    const date = value instanceof Date ? value : new Date(value);

    if (isNaN(date)) {
        return value;
    }

    return new Intl.DateTimeFormat("tr-TR", {
        day: "numeric",
        month: "long",
        year: "numeric",
        hour: "numeric",
        minute: "numeric",
    }).format(date);
}
