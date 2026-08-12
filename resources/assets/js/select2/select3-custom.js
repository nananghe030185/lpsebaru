// Tagify JS
(function () {
    ("use strict");
    // 1. Basic Select

    // The DOM element you wish to replace with Tagify
    var kbli = document.querySelector("#kbli");
    // initialize Tagify on the above input node reference
    new Tagify(kbli);

    var kataKunci = document.querySelector("#kata_kunci");
    // initialize Tagify on the above input node reference
    new Tagify(kataKunci);
})();
