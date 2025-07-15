//May need to change depending on earliest year
const startYear = 2020;

async function fetchData() {
  const res = await fetch("/api/fetch-archive-data/index.php");
  const data = await res.json();
  if (!data.success) {
    throw new Error(data.error);
  }

  const archiveData = data.data;

  for (const season of archiveData) {
    const anchor = document.createElement("a");
    const seasonName =
      startYear + season.id + "-" + (startYear + season.id + 1);
    anchor.href = "/" + seasonName;
    anchor.textContent = seasonName;

    document.getElementById("list").appendChild(anchor);
  }
}

window.addEventListener("load", fetchData);
