let height = 0;

let topElement;
let homeElement;
let headerElement;
let mainContentElement;

function changeScreenSize() {
  let width = document.documentElement.clientWidth;
  height = document.documentElement.clientHeight;
  let headers = document.getElementsByClassName("link");
  if (width < 1260) {
    for (let i = 0; i < headers.length; i++) {
      headers[i].style.display = "none";
    }
    if (document.getElementById("closeMobileMenu").style.display !== "inline") {
      document.getElementById("menuImage").style.display = "inline";
    }
  } else {
    for (let i = 0; i < headers.length; i++) {
      headers[i].style.display = "inline";
    }
    document.getElementById("menuImage").style.display = "none";
    closeMobileMenu();
  }
  document.getElementById("mobileMenu").style.height =
    (document.documentElement.clientHeight - 14).toString() + "px";
  changeScreenSizeMain(width);
  changeTop();
}

window.onload = changeScreenSize;

window.onresize = changeScreenSize;

document.onscroll = changeTop;

function openMobileMenu() {
  document.getElementById("mobileMenuContainer").style.display = "block";
  document.getElementById("header").style.boxShadow = "black 0 0 0";
  let i = 0;
  let animation = setInterval(function () {
    i += 12;
    document.getElementById("mobileMenuContainer").style.maxHeight =
      i.toString() + "px";
    if (i > document.documentElement.clientHeight) {
      clearInterval(animation);
    }
  }, 10);
}

function closeMobileMenu() {
  document.getElementById("header").style.boxShadow = "black 0 2px 5px";
  let i = document.documentElement.clientHeight;
  let animation = setInterval(function () {
    i -= 12;
    document.getElementById("mobileMenuContainer").style.maxHeight =
      i.toString() + "px";
    if (i < 0) {
      document.getElementById("mobileMenuContainer").style.display = "none";
      clearInterval(animation);
    }
  }, 10);
  changeTop();
}

async function initialize() {
  topElement = document.getElementById("top");
  homeElement = document.getElementById("home");
  headerElement = document.getElementById("header");
  mainContentElement = document.getElementById("mainContent");

  height = document.documentElement.clientHeight;

  changeScreenSize();

  let headers = document.getElementsByClassName("link");
  let headerMenus = document.getElementById("headerMenus").children;

  for (let i = 0; i < headers.length; i++) {
    headers[i].onmouseover = function () {
      try {
        headerMenus[i].style.display = "flex";
        if (document.documentElement.scrollTop <= 200) {
          document.getElementById("headerMenus").style.transform =
            "translateY(-200px)";
          headers[i].style.borderRadius = "0 0 30px 30px";
        } else {
          document.getElementById("headerMenus").style.transform =
            "translateY(0)";
          headers[i].style.borderRadius = "30px 30px 0 0";
        }
      } catch (err) {}
      headers[3].style.borderRadius = "30px";
      headers[4].style.borderRadius = "30px";
      headers[i].style.display = "inline";
      headers[i].style.backgroundColor = "#4c4eaf";
      try {
        headers[i].getElementsByClassName("menuRectangle")[0].style.animation =
          "barIn";
        headers[i].getElementsByClassName(
          "menuRectangle"
        )[0].style.animationDuration = "1s";
        setTimeout(function () {
          headers[i].getElementsByClassName("menuRectangle")[0].style.width =
            "100%";
        }, 950);
      } catch (err) {}
      document.body.style.cursor = "pointer";
    };
    headers[i].onmouseout = function () {
      try {
        headerMenus[i].style.display = "none";
      } catch (err) {}
      headers[i].style.backgroundColor = "rgba(0,0,0,0)";
      try {
        headers[i].getElementsByClassName("menuRectangle")[0].style.animation =
          "barOut";
        headers[i].getElementsByClassName(
          "menuRectangle"
        )[0].style.animationDuration = "1s";
        setTimeout(function () {
          headers[i].getElementsByClassName("menuRectangle")[0].style.width =
            "0";
        }, 950);
      } catch (err) {}
      document.body.style.cursor = "auto";
    };
    headers[i].style.opacity = "0";
    setTimeout(function () {
      headers[i].style.animation = "topAnimate";
      headers[i].style.animationDuration = "1s";
    }, 250 * (i + 1));
    setTimeout(function () {
      headers[i].style.opacity = "100%";
    }, 1000 + 250 * (i + 1));
  }
  for (let i = 0; i < headerMenus.length; i++) {
    headerMenus[i].onmouseover = function () {
      headerMenus[i].style.display = "flex";
      headers[i].style.backgroundColor = "#4c4eaf";
    };
    headerMenus[i].onmouseout = function () {
      headerMenus[i].style.display = "none";
      headers[i].style.backgroundColor = "rgba(0,0,0,0)";
    };
  }
  let mobileMenuOpeners = document.getElementsByClassName(
    "mobileDropDownOpener"
  );
  let mobileMenuDropDowns = document.getElementsByClassName("mobileDropDown");
  for (let i = 0; i < mobileMenuOpeners.length; i++) {
    mobileMenuOpeners[i].onclick = function () {
      for (let j = 0; j < mobileMenuDropDowns.length; j++) {
        if (j !== i) {
          mobileMenuDropDowns[j].style.display = "none";
          mobileMenuOpeners[j].style.transform = "rotate(90deg)";
        }
      }
      if (mobileMenuDropDowns[i].style.display === "inline-flex") {
        mobileMenuDropDowns[i].style.display = "none";
        mobileMenuOpeners[i].style.transform = "rotate(90deg)";
      } else {
        mobileMenuDropDowns[i].style.display = "inline-flex";
        mobileMenuOpeners[i].style.transform = "rotate(0deg)";
      }
    };
  }

  initializeCarousel();
  changeScreenSizeMain(document.documentElement.clientWidth);
  setTimeout(function () {
    window.scroll({
      top: 0,
      left: 0,
      behavior: "instant",
    });
  }, 10);

  let presidentName = "";
  let presidentEmail = "";
  let commissionerName = "";
  let commissionerEmail = "";

  try {
    const res = await fetch("/api/fetch-oversight/index.php?id=1");
    if (!res.ok) {
      console.error("Error fetching president.");
      return;
    }
    const json = await res.json();
    const data = await json.data;

    presidentName = data.name;
    presidentEmail = data.email;
    presidentImageUrl = data.image_url;
  } catch (error) {
    console.error("There was an error fetching data.");
  }

  try {
    const res = await fetch("/api/fetch-oversight/index.php?id=6");
    if (!res.ok) {
      console.error("Error fetching membership/training commissioner.");
      return;
    }
    const json = await res.json();
    const data = await json.data;

    commissionerName = data.name;
    commissionerEmail = data.email;
  } catch (error) {
    console.error("There was an error fetching data.");
  }

  document.getElementById("presidentLink").href = "mailto:" + presidentEmail;
  document.getElementById("commissionerLink").href =
    "mailto:" + commissionerEmail;
  document.getElementById("presidentLink").textContent =
    presidentName + " - President";
  document.getElementById("commissionerLink").textContent =
    commissionerName + " - Membership/Training Commissioner";

  document.getElementById("presidentNameHome").textContent = presidentName;
  document.getElementById("presidentImage").src = presidentImageUrl;
}

function changeTop() {
  const top = document.documentElement.scrollTop;
  let difference = height - top;
  if (difference < 74) {
    difference = 74;
  }

  topElement.style.height = (difference - 14).toString() + "px";
  topElement.style.marginTop = (height - difference - 14).toString() + "px";

  if (top >= height - 74) {
    homeElement.style.width = "275px";
    topElement.style.maxWidth = "1400px";
  } else {
    homeElement.style.width = "0";
    topElement.style.maxWidth = "100%";
  }

  const ratio = (top / (height - 68)).toFixed(5);

  headerElement.style.background = `rgba(20,32,57,${ratio})`;

  mainContentElement.style.background = `linear-gradient(to bottom,white,rgba(20,32,57,${ratio}))`;
}

function scrollDown() {
  document
    .getElementById("topImages")
    .getElementsByTagName("svg")[0].style.animation = "arrowClick";
  document
    .getElementById("topImages")
    .getElementsByTagName("svg")[0].style.animationDuration = "0.5s";
  document
    .getElementById("topImages")
    .getElementsByTagName("svg")[0].style.animationIterationCount = "1";
  setTimeout(function () {
    document
      .getElementById("topImages")
      .getElementsByTagName("svg")[0].style.animation = "arrowStatic";
    document
      .getElementById("topImages")
      .getElementsByTagName("svg")[0].style.animationDuration = "3s";
    document
      .getElementById("topImages")
      .getElementsByTagName("svg")[0].style.animationIterationCount =
      "infinite";
  }, 3000);
  let location = document.getElementById("message").offsetTop - 60;
  window.scroll({
    top: location,
    left: 0,
    behavior: "smooth",
  });
}

let slideshowIndex = 0;

function initializeCarousel() {
  let slides = document
    .getElementById("slideshow")
    .getElementsByClassName("slide");
  slides[0].id = "middle";
}

function runCarousel(direction) {
  let slides = document
    .getElementById("slideshow")
    .getElementsByClassName("slide");
  slideshowIndex += direction;
  if (slideshowIndex === slides.length) {
    slideshowIndex = 0;
  } else if (slideshowIndex < 0) {
    slideshowIndex = slides.length - 1;
  }
  document.getElementById("middle").removeAttribute("id");
  slides[slideshowIndex].id = "middle";
  changePageHeader(document.documentElement.clientWidth);
}

let carousel = setInterval(() => {
  runCarousel(1);
}, 5000); // Change slide every 5 seconds

function carouselForward() {
  clearInterval(carousel);
  runCarousel(1);
}

function carouselBack() {
  clearInterval(carousel);
  runCarousel(-1);
}

function changeScreenSizeMain() {
  const width = document.documentElement.clientWidth;
  try {
    changePageHeader(width);
  } catch (err) {}
  if (width < 1200) {
    document
      .getElementById("message")
      .getElementsByTagName("section")[0].style.flexDirection = "column";
  } else {
    document
      .getElementById("message")
      .getElementsByTagName("section")[0].style.flexDirection = "row";
  }
}

function changePageHeader(width) {
  if (width <= 1400) {
    document.getElementById("middle").getElementsByTagName("p")[0].style.width =
      (width - 60).toString() + "px";
    document.getElementById("carouselAdditional").style.width =
      (width - 60).toString() + "px";
  } else {
    let margins = (width - 1400) / 2;
    document.getElementById("middle").getElementsByTagName("p")[0].style.width =
      1340 + "px";
    document.getElementById("carouselAdditional").style.width = 1340 + "px";
  }
}

window.addEventListener("load", initialize);
