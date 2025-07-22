const Editor = toastui.Editor;

const editor = new Editor({
  el: document.querySelector("#editor"),
  height: "500px",
  initialEditType: "wysiwyg",
  previewStyle: "vertical",
  toolbarItems: [
    ["heading", "bold", "italic", "strike"],
    ["hr", "quote"],
    ["ul", "ol", "task"],
    ["table", "link", "image"],
    ["codeblock"],
  ],
  usageStatistics: false,
});

editor.removeHook("addImageBlobHook"); // ensure no prior handlers

editor.addHook("addImageBlobHook", (blob, callback) => {
  alert("Image file uploads are disabled. Please use an image URL instead.");
  return false; // cancel upload
});

async function fetchData() {
  const slug = window.location.pathname.split("/")[3];
  const res = await fetch(`/api/fetch-post?slug=${slug}`);
  const json = await res.json();
  const originalData = await json.data;

  document.querySelector("#title").value = originalData.title;
  editor.setMarkdown(originalData.markdown);

  document.title = `Edit ${originalData.title} | ICDA`;
}

function save() {
  if (
    confirm(
      "Are you sure you want to save? Any previous data will be overwritten."
    )
  ) {
    const formData = new FormData(document.querySelector("#updatePost"));

    // Add fields
    formData.append("slug", window.location.pathname.split("/")[3]);
    formData.append("markdown", editor.getMarkdown());
    formData.append(
      "deleteImage",
      document.querySelector("#deleteImage").checked
    );

    fetch("/api/update-post/index.php", {
      method: "POST",
      body: formData,
      // Don't set the Content-Type manually!
      // fetch will automatically add the correct boundary and content type.
    })
      .then((response) => response.json())
      .then((result) => {
        console.log("Success:", result);
        alert("Post saved successfully!");
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("An error occurred while saving the post: " + error.message);
      });
  }
}

function checkBox() {
  if (document.querySelector("#deleteImage").checked) {
    document.querySelector("#image").disabled = true;
  } else {
    document.querySelector("#image").disabled = false;
  }
}

function deletePost() {
  if (window.location.pathname.split("/")[3] === "new-website") {
    alert(
      "Sorry, you cannot delete the 'New Website' post - it's a vital part of the code."
    );
    return;
  }
  if (
    confirm(
      "Are you sure you want to delete this post? This action cannot be undone."
    )
  ) {
    if (
      prompt("Type the exact title of the post to confirm deletion:") !==
      document.querySelector("#title").value
    ) {
      alert("Title does not match. Post deletion cancelled.");
      return;
    }
    const slug = window.location.pathname.split("/")[3];
    fetch(`/api/delete-post/index.php?slug=${slug}`, {
      method: "DELETE",
    })
      .then((response) => response.json())
      .then((result) => {
        console.log("Success:", result);
        alert("Post deleted successfully!");
        window.location.href = "/admin/news"; // Redirect to news list
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("An error occurred while deleting the post: " + error.message);
      });
  }
}

window.addEventListener("load", fetchData);
