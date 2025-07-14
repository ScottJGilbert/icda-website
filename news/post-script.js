async function fetchData() {
  const slug = window.location.pathname.split("/")[2];
  const res = await fetch(`/api/fetch-post/index.php?slug=${slug}`);
  const json = await res.json();
  const originalData = await json.data;

  document.querySelector("#title").textContent = originalData.title;
  document.querySelector("#image").src =
    originalData.image_url === ""
      ? "/public/images/ICDALogo.png"
      : originalData.image_url;
  document.querySelector("#viewer").innerHTML = marked.parse(
    originalData.markdown
  );
  document.querySelector("#creationDate").textContent = `Created on: ${new Date(
    originalData.creation_date
  ).toLocaleDateString()}`;
  document.querySelector("#editDate").textContent = `Last edited on: ${new Date(
    originalData.edit_date
  ).toLocaleDateString()}`;

  document.title = `${originalData.title} | ICDA`;
}

window.onload = fetchData;
