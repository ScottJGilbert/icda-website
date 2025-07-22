let numPages = 0;

async function fetchPages() {
  const res = await fetch("/api/fetch-pages/index.php");
  const data = await res.json();
  if (!data.success) {
    throw new Error(data.error);
  }

  numPages = data.data;
}

function pageUp() {
  changePage(1);
}

function pageDown() {
  changePage(-1);
}

function changePage(amount) {
  const queryParams = new URLSearchParams(window.location.search);
  const queryString = window.location.search;
  const pageLocation = queryString.indexOf("page");
  const page =
    pageLocation === -1 ? 1 : Number(queryString.slice(pageLocation + 5));
  queryParams.set("page", page + amount);

  document.getElementById("downArrow").disabled = page + amount === 1;
  document.getElementById("upArrow").disabled = page + amount === numPages;
}

async function fetchData() {
  const queryString = window.location.search;
  const pageLocation = queryString.indexOf("page");
  const page =
    pageLocation === -1 ? 1 : Number(queryString.slice(pageLocation + 5));

  const res = await fetch("/api/fetch-posts/index.php?page=" + page);
  const data = await res.json();
  if (!data.success) {
    throw new Error(data.error);
  }

  const posts = data.data;
  document.getElementById("list").innerHTML = "";

  for (const post of posts) {
    const box = document.createElement("div");
    box.className = "post";
    box.innerHTML = `
      <img src="${post.image_url}" />
      <h2>${post.title}</h2>
      <h3><i>${new Date(post.creation_date)}</i></h3>
      <a href="${post.slug}">Read More →</a>
    `;

    document.getElementById("list").appendChild(box);
  }
}

window.addEventListener("load", fetchPages);
window.addEventListener("load", fetchData);
window.addEventListener("popstate", fetchData);
