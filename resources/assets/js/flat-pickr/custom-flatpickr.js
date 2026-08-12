// Custom-flatpickr JS
(function () {
    const datePickerID = [
        "datetime-local",
        "datetime-local3",
        "datetime-localEvent",
    ]; // Array of IDs
    const timePickerID = ["time-picker1", "time-picker2"]; // Array of IDs
    const rangeDateID = ["range-date"]; // Array of IDs

    // 2. Human Friendly
    flatpickr("#human-friendly", {
        altInput: true,
        altFormat: "j F Y",
        dateFormat: "Y-m-d",
    });
})();
