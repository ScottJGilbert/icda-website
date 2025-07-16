//Everything below is for the actual page content and varies by file

function changeScreenSizeMain() {
  const width = document.documentElement.clientWidth;
  const height = document.documentElement.clientHeight;
  let headerHeight = height - 394;
  let minHeight = 0;
  const elements = document
    .getElementById("pageHeader")
    .getElementsByTagName("section")[0].children;
  for (let i = 1; i < elements.length; i++) {
    minHeight += elements[i].getBoundingClientRect().height;
  }
  minHeight += 218;
  if (headerHeight < minHeight) {
    headerHeight = minHeight;
  }
  document.getElementById("pageHeader").style.height =
    headerHeight.toString() + "px";
  document
    .getElementById("pageHeader")
    .getElementsByTagName("section")[0].style.height =
    (headerHeight - 80).toString() + "px";
  if (width < 1200) {
    const navigationButtons = document.getElementsByClassName(
      "aboutNavigationLink"
    );
    for (let i = 0; i < navigationButtons.length; i++) {
      navigationButtons[i].style.width = "70%";
    }
    document
      .getElementById("quote")
      .getElementsByTagName("section")[0].style.flexDirection = "column";
  } else {
    const navigationButtons = document.getElementsByClassName(
      "aboutNavigationLink"
    );
    for (let i = 0; i < navigationButtons.length; i++) {
      navigationButtons[i].style.width = "15.2%";
    }
    document
      .getElementById("quote")
      .getElementsByTagName("section")[0].style.flexDirection = "row";
  }
}

async function fetchData() {
  try {
    const res = await fetch("/api/fetch-number-schools/index.php");
    const data = await res.json();
    if (!data.success) {
      throw new Error(data.error);
    }

    numSchools = data.data;
    document.getElementById("numSchools").innerHTML = numSchools;
  } catch (error) {
    console.error("Error fetching archive data: ", error);
  }
}

window.addEventListener("load", fetchData);
window.addEventListener("load", changeScreenSizeMain);
window.addEventListener("resize", changeScreenSizeMain);
