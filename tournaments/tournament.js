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

window.addEventListener("resize", changeScreenSizeMain);
window.addEventListener("load", changeScreenSizeMain);
