// Mail box editor JS

(function () {
  var editor = new Quill("#editor", {
    modules: { toolbar: "#toolbar" },
    theme: "snow",
    placeholder: "Enter your messages11111...",
  });

  var editor1 = new Quill("#editor1", {
    modules: { toolbar: "#toolbar1" },
    theme: "snow",
    placeholder: "Enter your messages1231313...",
  });
})();
