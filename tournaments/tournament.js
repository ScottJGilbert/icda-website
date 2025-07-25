//Everything below is for the actual page content and varies by file

function changeScreenSizeMain() {
  const width = document.documentElement.clientWidth;
  if (width < 550) {
    document.getElementById("navigation").style.maxWidth = "100%";
    document.getElementById("navigation").style.marginTop = "10px";
    document.getElementById("navigation").style.marginBottom = "10px";
    document.getElementById("textSection").style.maxWidth = width + "px";
  } else {
    document.getElementById("navigation").style.maxWidth = "200px";
    document.getElementById("navigation").style.margin = "0";
    document.getElementById("textSection").style.maxWidth =
      Math.min(1400, width) - 330 + "px";
  }
}

async function fetchData() {
  const name = window.location.pathname.split("/")[2].slice(5);
  const id = name === "state" ? 6 : Number(name);

  const res = await fetch(`/api/fetch-tournament/index.php?id=${id}`);
  const data = await res.json();
  if (!data.success) {
    throw new Error(data.error);
  }

  document.getElementById("date").textContent = new Date(
    data.date
  ).toDateString();
  document.getElementById("school").textContent =
    id === 6 ? "Harper College" : data.school_name;
  document.getElementById("logo").src =
    id === 6 ? "/public/images/harperCollege.svg" : data.school_image;
  document.getElementById("tabroom").href = data.tabroom;

  document.getElementById("list").innerHTML = ""; // Clear previous links
  for (const contact of data.contacts) {
    const anchor = document.createElement("a");
    anchor.href = "mailto:" + contact.email;
    anchor.target = "_blank";
    anchor.className = "navigationLink";
    anchor.textContent = data.name;
    document.getElementById("list").appendChild(anchor);
  }

  try {
    const res = await fetch("legislation.pdf");
    if (!res.ok) {
      document.getElementById("legislation").style.display = "none";
    }
  } catch (error) {
    console.error("Error fetching legislation PDF:", error);
    document.getElementById("legislation").style.display = "none";
  }

  try {
    const res = await fetch("results.pdf");
    if (!res.ok) {
      document.getElementById("results").style.display = "none";
    }
  } catch (error) {
    console.error("Error fetching results PDF:", error);
    document.getElementById("results").style.display = "none";
  }
}

window.addEventListener("load", fetchData);
window.addEventListener("resize", changeScreenSizeMain);
window.addEventListener("load", changeScreenSizeMain);
