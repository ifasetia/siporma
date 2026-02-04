// ================================
// CSS IMPORT (FIX VITE)
// ================================
import "jsvectormap/dist/jsvectormap.css"; // <-- FIX disini
import "flatpickr/dist/flatpickr.css";
import "dropzone/dist/dropzone.css";
// import "../../css/template/style.css";

// ================================
// LIBRARY IMPORT
// ================================
import Alpine from "alpinejs";
import persist from "@alpinejs/persist";
import flatpickr from "flatpickr";
import Dropzone from "dropzone";

// ================================
// COMPONENT IMPORT
// ================================
import chart01 from "./components/charts/chart-01";
import chart02 from "./components/charts/chart-02";
import chart03 from "./components/charts/chart-03";
import map01 from "./components/map-01";
import "./components/calendar-init.js";
import "./components/image-resize";

// ================================
// ALPINE INIT
// ================================
Alpine.plugin(persist);
window.Alpine = Alpine;
Alpine.start();

// ================================
// FLATPICKR INIT
// ================================
document.addEventListener("DOMContentLoaded", () => {
    const datepickers = document.querySelectorAll(".datepicker");

    if (datepickers.length) {
        flatpickr(".datepicker", {
            mode: "range",
            static: true,
            monthSelectorType: "static",
            dateFormat: "M j",
            defaultDate: [
                new Date().setDate(new Date().getDate() - 6),
                new Date(),
            ],
            onReady: (selectedDates, dateStr, instance) => {
                instance.element.value = dateStr.replace("to", "-");
                const customClass = instance.element.getAttribute("data-class");
                if (customClass) {
                    instance.calendarContainer.classList.add(customClass);
                }
            },
            onChange: (selectedDates, dateStr, instance) => {
                instance.element.value = dateStr.replace("to", "-");
            },
        });
    }
});

// ================================
// DROPZONE INIT
// ================================
document.addEventListener("DOMContentLoaded", () => {
    const dropzoneArea = document.querySelector("#demo-upload");

    if (dropzoneArea) {
        new Dropzone("#demo-upload", { url: "/file/post" });
    }
});

// ================================
// COMPONENT INIT
// ================================
document.addEventListener("DOMContentLoaded", () => {
    chart01();
    chart02();
    chart03();
    map01();
});

// ================================
// YEAR AUTO UPDATE
// ================================
const year = document.getElementById("year");
if (year) {
    year.textContent = new Date().getFullYear();
}

// ================================
// COPY BUTTON
// ================================
document.addEventListener("DOMContentLoaded", () => {
    const copyInput = document.getElementById("copy-input");
    if (!copyInput) return;

    const copyButton = document.getElementById("copy-button");
    const copyText = document.getElementById("copy-text");
    const websiteInput = document.getElementById("website-input");

    copyButton.addEventListener("click", () => {
        navigator.clipboard.writeText(websiteInput.value).then(() => {
            copyText.textContent = "Copied";

            setTimeout(() => {
                copyText.textContent = "Copy";
            }, 2000);
        });
    });
});

// ================================
// SEARCH SHORTCUT
// ================================
document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("search-input");
    const searchButton = document.getElementById("search-button");

    if (!searchInput || !searchButton) return;

    function focusSearchInput() {
        searchInput.focus();
    }

    searchButton.addEventListener("click", focusSearchInput);

    document.addEventListener("keydown", (event) => {
        if ((event.metaKey || event.ctrlKey) && event.key === "k") {
            event.preventDefault();
            focusSearchInput();
        }

        if (event.key === "/" && document.activeElement !== searchInput) {
            event.preventDefault();
            focusSearchInput();
        }
    });
});
