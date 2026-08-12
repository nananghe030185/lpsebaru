// Add blog editor JS

(function () {
  // standard Member
  var editormember = new Quill("#editormember", {
    modules: { toolbar: "#toolbarmember" },
    theme: "snow",
    placeholder: "Enter your messages...",
  });

  var quillEditor = document.getElementById('quill-editor-area');
  editormember.on('text-change', function() {
    quillEditor.value = editormember.root.innerHTML;
  });

  quillEditor.addEventListener('input', function() {
    editormember.root.innerHTML = quillEditor.value;
  });

  // Editor Non Member
  var editornonmember = new Quill("#editornonmember", {
    modules: { toolbar: "#toolbarnonmember" },
    theme: "snow",
    placeholder: "Enter your messages...",
  });

  var quillEditor = document.getElementById('quill-editor-area');
  editornonmember.on('text-change', function() {
    quillEditor.value = editornonmember.root.innerHTML;
  });

  quillEditor.addEventListener('input', function() {
    editornonmember.root.innerHTML = quillEditor.value;
  });

  // Editor Semua Member
  var editorsemua = new Quill("#editorsemua", {
    modules: { toolbar: "#toolbarsemua" },
    theme: "snow",
    placeholder: "Enter your messages...",
  });

  var quillEditor = document.getElementById('quill-editor-area');
  editorsemua.on('text-change', function() {
    quillEditor.value = editorsemua.root.innerHTML;
  });

  quillEditor.addEventListener('input', function() {
    editorsemua.root.innerHTML = quillEditor.value;
  });

  // Editor Outer
  var editorouter = new Quill("#editorouter", {
    modules: { toolbar: "#toolbarouter" },
    theme: "snow",
    placeholder: "Enter your messages...",
  });

  var quillEditor = document.getElementById('quill-editor-area');
  editorouter.on('text-change', function() {
    quillEditor.value = editorouter.root.innerHTML;
  });

  quillEditor.addEventListener('input', function() {
    editorouter.root.innerHTML = quillEditor.value;
  });
})();