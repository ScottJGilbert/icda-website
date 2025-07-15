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

function changeTournaments(width) {
  if (width < 1080) {
    document.getElementById("noviceWorkshopImage").style.clipPath =
      "polygon(0 0, 100% 0, 100% 100%, 0% 100%)";
    document.getElementById("noviceWorkshopImage").style.marginLeft = "auto";
    document.getElementById("noviceWorkshopImage").style.marginRight = "auto";
    document.getElementById("noviceWorkshopImage").style.marginTop = "20px";
    document.getElementById("noviceWorkshopImage").style.marginBottom = "20px";
    document.getElementById("noviceWorkshopImage").style.borderRadius = "20px";
    document.getElementById("noviceWorkShop").style.flexDirection = "column";
    document.getElementById("noviceWorkShopTextContainer").style.textAlign =
      "center";
  } else {
    document.getElementById("noviceWorkshopImage").style.clipPath =
      "polygon(0 0, 81% 0, 100% 100%, 0% 100%)";
    document.getElementById("noviceWorkshopImage").style.marginLeft = "0";
    document.getElementById("noviceWorkshopImage").style.marginRight = "0";
    document.getElementById("noviceWorkshopImage").style.marginTop = "0";
    document.getElementById("noviceWorkshopImage").style.marginBottom = "0";
    document.getElementById("noviceWorkshopImage").style.borderRadius = "0";
    document.getElementById("noviceWorkShop").style.flexDirection = "row";
    document.getElementById("noviceWorkShopTextContainer").style.textAlign =
      "left";
  }
}

window.addEventListener("resize", changeScreenSizeMain);
