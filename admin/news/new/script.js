const Editor = toastui.Editor;

const editor = new Editor({
  el: document.querySelector("#editor"),
  height: "500px",
  initialEditType: "wysiwyg",
  initialValue: "Start writing your post here...",
  previewStyle: "vertical",
  toolbarItems: [
    ["heading", "bold", "italic", "strike"],
    ["hr", "quote"],
    ["ul", "ol", "task"],
    ["table", "link", "image"],
    ["codeblock"],
  ],
});

editor.removeHook("addImageBlobHook"); // ensure no prior handlers

editor.addHook("addImageBlobHook", (blob, callback) => {
  alert("Image file uploads are disabled. Please use an image URL instead.");
  return false; // cancel upload
});

// Prevent drag-and-drop image insertions
editor.getRootElement().addEventListener("drop", (e) => {
  if ([...e.dataTransfer.items].some((item) => item.kind === "file")) {
    e.preventDefault();
    alert(
      "Dragging and dropping images is disabled. Please insert an image URL through the image tool instead."
    );
  }
});

// Prevent paste image insertions
editor.getRootElement().addEventListener("paste", (e) => {
  if ([...e.clipboardData.items].some((item) => item.kind === "file")) {
    e.preventDefault();
    alert(
      "Pasting images is disabled. Please insert an image URL through the image tool instead."
    );
  }
});

//Use this for fetching unique data (a lot more efficient than HTML)
function button() {
  alert(editor.getMarkdown());
}
