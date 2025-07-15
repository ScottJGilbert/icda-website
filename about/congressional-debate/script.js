//Everything below is for the actual page content and varies by file

function changeScreenSizeMain() {
  const width = document.documentElement.clientWidth;
  changeSection(
    document.getElementById("billWriting").getElementsByTagName("section")[0],
    width
  );
  changeSection(
    document.getElementById("speeches").getElementsByTagName("section")[0],
    width
  );
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

function changeSection(section, width) {
  if (width < 1000) {
    section.style.flexDirection = "column";
  } else {
    section.style.flexDirection = "row";
  }
}

window.addEventListener("resize", changeScreenSizeMain);
