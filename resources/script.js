//Everything below is for the actual page content and varies by file

function changeScreenSizeMain() {
  const width = document.documentElement.clientWidth;
  const height = document.documentElement.clientHeight;
  changePageHeader(height);
  if (width < 1200) {
    let navigationButtons = document.getElementsByClassName(
      "resourcesNavigationLink"
    );
    for (let i = 0; i < navigationButtons.length; i++) {
      navigationButtons[i].style.width = "70%";
    }
  } else {
    let navigationButtons = document.getElementsByClassName(
      "resourcesNavigationLink"
    );
    for (let i = 0; i < navigationButtons.length; i++) {
      navigationButtons[i].style.width = "21%";
    }
  }
}

function changePageHeader(height) {
  let headerHeight = height - 394;
  let minHeight = 0;
  let elements = document
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
}

window.addEventListener("resize", changeScreenSizeMain);
