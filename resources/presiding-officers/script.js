//Everything below is for the actual page content and varies by file

function changeScreenSizeMain() {
  const width = document.documentElement.clientWidth;
  if (width <= 850) {
    for (let i of document.getElementsByClassName("document")) {
      i.style.flexDirection = "column";
      i.style.textAlign = "center";
    }
  } else {
    for (let i of document.getElementsByClassName("document")) {
      i.style.flexDirection = "row";
      i.style.textAlign = "left";
    }
  }
}

window.addEventListener("resize", changeScreenSizeMain);
