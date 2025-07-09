const Editor = toastui.Editor;

const viewer = new toastui.Editor({
  el: document.querySelector("#viewer"),
  initialValue: "No content available.",
});

async function fetchData() {
  const slug = window.location.pathname.split("/")[3];
  const res = await fetch(`/api/fetch-post/index.php?slug=${slug}`);
  const json = await res.json();
  const originalData = await json.data;

  document.querySelector("#title").value = originalData.title;
  viewer.setMarkdown(originalData.markdown);
  document.querySelector("#creationDate").textContent = `Created on: ${new Date(
    originalData.creation_date
  ).toLocaleDateString()}`;
  document.querySelector("#editDate").textContent = `Last edited on: ${new Date(
    originalData.edit_date
  ).toLocaleDateString()}`;

  document.title = `${originalData.title} | ICDA`;
}

window.onload = fetchData;
