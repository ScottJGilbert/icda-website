//Everything below is for the actual page content and varies by file

function changeScreenSizeMain() {
  const width = document.documentElement.clientWidth;
  const height = document.documentElement.clientHeight;
  const headerHeight = height - 394;
  const minHeight = 0;
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

window.addEventListener("resize", changeScreenSizeMain);
