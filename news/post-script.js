const Editor = toastui.Editor;

const viewer = new toastui.Editor({
  el: document.querySelector("#viewer"),
  initialValue: originalData.markdown ?? "No content available.",
});

async function fetchData() {
  const slug = window.location.pathname.split("/")[3];
  const res = await fetch(`/api/fetch-post?slug=${slug}`);
  const originalData = await res.json();

  document.querySelector("#title").value = originalData.title ?? "";
  viewer.setMarkdown(originalData.markdown ?? "No content available.");
  document.querySelector("#creationDate").textContent = `Created on: ${new Date(
    originalData.creation_date
  ).toLocaleDateString()}`;
  document.querySelector("#editDate").textContent = `Last edited on: ${new Date(
    originalData.edit_date
  ).toLocaleDateString()}`;

  document.title = `${originalData.title} | ICDA`;
}
