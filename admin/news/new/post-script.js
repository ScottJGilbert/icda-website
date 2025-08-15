let slugs = [];

async function fetchSlugs() {
  try {
    const response = await fetch("/api/fetch-slugs/index.php");
    if (!response.ok) {
      throw new Error("Network response was not ok");
    }
    const data = await response.json();
    slugs = data.data;
    console.log("Slugs fetched successfully:", slugs);
  } catch (error) {
    console.error("Error fetching slugs:", error);
  }
}

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
});

editor.removeHook("addImageBlobHook"); // ensure no prior handlers

editor.addHook("addImageBlobHook", (blob, callback) => {
  alert("Image file uploads are disabled. Please use an image URL instead.");
  return false; // cancel upload
});

async function save() {
  if (
    confirm(
      "Are you sure you want to save? Any previous data will be overwritten."
    )
  ) {
    const formData = new FormData(document.querySelector("#newPost"));
    formData.append("markdown", editor.getMarkdown());

    if (!formData.get("title")) {
      alert("Title is required.");
      return;
    }
    const slug = document
      .querySelector("#title")
      .value.toLowerCase()
      .trim()
      .replace(/[^a-z0-9]+/g, "-")
      .replace(/^-+|-+$/g, "");

    if (slugs.includes(slug) || slug === "new") {
      alert(
        "A post with this slug already exists. Please choose a different title."
      );
      return;
    }

    if (document.querySelector("#image").files.length > 0) {
      formData.append("containsImage", true);
    } else {
      formData.append("containsImage", false);
    }

    const res = await fetch("/api/new-post/index.php", {
      method: "POST",
      body: formData,
      // Don't set the Content-Type manually!
      // fetch will automatically add the correct boundary and content type.
    });
    const json = await res.json();

    if (!res.ok) {
      const error = json.error || "Unknown error occurred";
      alert("An error occurred while saving the post: " + error.message);
      return;
    }

    window.location.href = `/admin/news/${slug}`;
  }
}

window.addEventListener("load", fetchSlugs);
