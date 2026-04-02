// Select2 JS

setTimeout(function () {
    (function ($) {
        "use strict";
        $(".select2").select2({
            placeholder: "Pilih Data yang tersedia",
            width: "resolve",
            allowClear: true,
        });

        // Single Search Select
        $(".invoice-status").select2({
            placeholder: "Pilih Status",
            width: "resolve",
            allowClear: true,
        });

        $(".jenis_pengadaan").select2({
            placeholder: "Pilih Jenis Pengadaan",
            width: "resolve",
            allowClear: true,
        });

        $(".jenis_metode").select2({
            placeholder: "Pilih Jenis Metode",
            width: "resolve",
            allowClear: true,
        });

        $(".tahapan_tender").select2({
            placeholder: "Pilih Tahapan Tender",
            width: "resolve",
            allowClear: true,
        });

        $(".select_upline").select2({
            placeholder: "Pilih Upline",
            width: "resolve",
            allowClear: true,
        });

        $(".select_downline").select2({
            placeholder: "Pilih Downline",
            width: "resolve",
            allowClear: true,
        });

        $(".keuangan_member").select2({
            placeholder: "Pilih Member",
            width: "resolve",
            allowClear: true,
        });

        $(".pengumuman_status").select2({
            placeholder: "Pilih Status",
            width: "resolve",
            allowClear: true,
        });

        $(".jenis_klpd").select2({
            placeholder: "Pilih Jenis KLPD",
            width: "resolve",
            allowClear: true,
        });

        $(".select_status").select2({
            placeholder: "Pilih Status",
            width: "resolve",
            allowClear: true,
        });

        $(".select_channel").select2({
            placeholder: "Pilih Channel",
            width: "resolve",
            allowClear: true,
        });

        $(".autorespon-status").select2({
            placeholder: "Pilih Status",
            width: "resolve",
            allowClear: true,
        });

        $(".js-example-basic-single").select2({
            placeholder: "Select Your Name",
            allowClear: true,
        });
        $(".js-example-disabled-results").select2();

        // Multi Select
        $(".js-example-basic-multiple").select2();

        // With Placeholder
        $(".js-example-placeholder-multiple").select2({
            placeholder: "Select Your Name",
        });

        // With Placeholder - category
        $(".js-category-placeholder-multiple").select2({
            placeholder: "Select Categories",
        });

        // With Placeholder - tag
        $(".js-tag-placeholder-multiple").select2({
            placeholder: "Select Tags",
        });

        //Limited Numbers
        $(".js-example-basic-multiple-limit").select2({
            maximumSelectionLength: 2,
        });

        //RTL Support
        $(".js-example-rtl").select2({
            dir: "rtl",
        });
        // Responsive width Search Select
        $(".js-example-basic-hide-search").select2({
            minimumResultsForSearch: Infinity,
        });
        $(".js-example-disabled").select2({
            disabled: true,
        });
        $(".js-programmatic-enable").on("click", function () {
            $(".js-example-disabled").prop("disabled", false);
        });
        $(".js-programmatic-disable").on("click", function () {
            $(".js-example-disabled").prop("disabled", true);
        });
    })(jQuery);
}, 350);
