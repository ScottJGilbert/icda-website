//Everything below is for the actual page content and varies by file

function changeScreenSizeMain() {
  const width = document.documentElement.clientWidth;
  if (width < 550) {
    document.getElementById("aboutNavigation").style.maxWidth = "100%";
    document.getElementById("aboutNavigation").style.marginTop = "10px";
    document.getElementById("aboutNavigation").style.marginBottom = "10px";

    document
      .getElementById("pageHeader")
      .getElementsByTagName("svg")[0].style.display = "block";
  } else {
    document.getElementById("aboutNavigation").style.maxWidth = "200px";
    document.getElementById("aboutNavigation").style.margin = "0";

    document
      .getElementById("pageHeader")
      .getElementsByTagName("svg")[0].style.display = "inline";
  }
}

async function fetchData() {
  try {
    const res = await fetch("/api/fetch-all-oversight/index.php");
    const data = await res.json();
    if (!data.success) {
      throw new Error(data.error);
    }
    const oversightNames = [
      "President",
      "Secretary",
      "Treasurer",
      "Executive",
      "Technology",
      "Membership/Training",
      "At-Large",
    ];
    const oversight = data.data;
    for (let i = 0; i < 3; i++) {
      const director = document.createElement("div");
      director.className = "commissioner";
      director.innerHTML = `
        <div class="imageContainer">
          <img src="${oversight[i].image_url}" alt="${oversight[i].name}" />
        </div>
        <p class="descriptionText"><b>${oversight[i].name}</b></p>
        <p class="descriptionText">${oversightNames[i]}</p>
      `;
      document.getElementById("directors").appendChild(director);
    }
    for (let i = 0; i < 7; i++) {
      const commissioner = document.createElement("div");
      commissioner.className = "commissioner";
      commissioner.innerHTML = `
        <div class="imageContainer">
          <img src="${oversight[i].image_url}" alt="${oversight[i].name}" />
        </div>
        <p class="descriptionText"><b>${oversight[i].name}</b></p>
        <p class="descriptionText">${oversightNames[i]}</p>
      `;
      document.getElementById("commissioners").appendChild(commissioner);
    }
  } catch (error) {
    console.error("There was an error fetching oversight members: ", error);
  }
}

window.addEventListener("load", fetchData);
window.addEventListener("load", changeScreenSizeMain);
window.addEventListener("resize", changeScreenSizeMain);
