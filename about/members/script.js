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
    const res = await fetch("/api/fetch-schools/index.php");
    const data = await res.json();
    if (!data.success) {
      throw new Error(data.error);
    }
    const schools = data.data;

    const res2 = await fetch("/api/fetch-coaches");
    const data2 = await res2.json();
    if (!data2.success) {
      throw new Error(data2.error);
    }
    const coaches = data2.data;
    for (const school of schools) {
      const schoolElement = document.createElement("li");
      schoolElement.innerHTML = `
        <b>${school.name}</b>
        <img src="${school.image_url}" alt="${school.name}" />
      `;
      const coachDiv = document.createElement("div");
      for (const coach of coaches) {
        if (coach.school_id === school.id) {
          const coachElement = document.createElement("a");
          coachElement.textContent = coach.name;
          coachElement.href = "mailto:" + coach.email;
          coachDiv.appendChild(coach);
        }
      }
      schoolElement.appendChild(coachDiv);
      document.getElementById("list").appendChild(schoolElement);
    }
  } catch (error) {
    console.error("There was an error fetching oversight members: ", error);
  }
}

window.addEventListener("load", fetchData);
window.addEventListener("load", changeScreenSizeMain);
window.addEventListener("resize", changeScreenSizeMain);
