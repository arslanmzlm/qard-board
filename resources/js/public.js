import "toastify-js/src/toastify.css";
import ClipboardJS from "clipboard";
import Toastify from "toastify-js";
import colors from "tailwindcss/colors.js";
import {formatIncompletePhoneNumber} from "libphonenumber-js";

document.addEventListener("DOMContentLoaded", () => {
    const clipboard = new ClipboardJS('.clipboard-btn');

    clipboard.on('success', function (e) {
        Toastify({
            text: "IBAN Panoya Kopyalandı",
            duration: 1250,
            gravity: "bottom",
            position: "center",
            stopOnFocus: true,
            style: {
                background: colors.slate["500"],
            },
            offset: {
                y: 80
            },
        }).showToast();

        e.clearSelection();
    });

    const phones = document.querySelectorAll('.phone');
    if (phones && phones.length) {
        phones.forEach((el) => {
            el.textContent = formatIncompletePhoneNumber(el.textContent, "TR");
        });
    }
});
