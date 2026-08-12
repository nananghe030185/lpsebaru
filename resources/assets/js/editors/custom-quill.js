// Mail box editor JS

(function () {
  var editor = new Quill("#editor", {
    modules: { toolbar: true },
    theme: "snow",
    placeholder: "Enter your messages...",
  });

  var editor1 = new Quill("#editor1", {
    modules: { toolbar: "#toolbar1" },
    theme: "snow",
    placeholder: "Enter your messages...",
  });
})();
