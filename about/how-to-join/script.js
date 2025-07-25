//Everything below is for the actual page content and varies by file

function changeScreenSizeMain() {
  const width = document.documentElement.clientWidth;
  changeHeaderSize(width);
}

function changeHeaderSize(width) {
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

async function initializePage() {
  let questions = document
    .getElementById("FAQ")
    .getElementsByClassName("question");
  let answers = document.getElementById("FAQ").getElementsByClassName("answer");
  for (let i = 0; i < questions.length; i++) {
    questions[i].onclick = function () {
      for (let j = 0; j < answers.length; j++) {
        if (j !== i) {
          questions[j].getElementsByTagName("img")[0].style.transform =
            "rotate(0deg)";
          answers[j].style.display = "none";
          if (j === questions.length - 1) {
            questions[j].style.borderRadius = "0 0 20px 20px";
            answers[j].style.borderRadius = "0";
          }
        }
      }
      if (answers[i].style.display === "block") {
        questions[i].getElementsByTagName("img")[0].style.transform =
          "rotate(0deg)";
        answers[i].style.display = "none";
        if (i === questions.length - 1) {
          questions[i].style.borderRadius = "0 0 20px 20px ";
          answers[i].style.borderRadius = "0";
        }
      } else {
        questions[i].getElementsByTagName("img")[0].style.transform =
          "rotate(90deg)";
        answers[i].style.display = "block";
        if (i === questions.length - 1) {
          questions[i].style.borderRadius = "0";
          answers[i].style.borderRadius = "0 0 20px 20px ";
        }
      }
    };
  }

  try {
    const res = await fetch("/api/fetch-oversight/index.php?id=1");
    const data = await res.json();
    if (!res.ok || !data.success) {
      console.error("Error fetching president.");
    }
    document.getElementById("president").textContent = data.name;
    document.getElementById("president").href = "mailto:" + data.email;
  } catch (error) {
    console.error("There was an error fetching data.");
  }

  try {
    const res = await fetch("/api/fetch-oversight/index.php?id=6");
    const data = await res.json();
    if (!res.ok || !data.success) {
      console.error("Error fetching membership/training commissioner.");
    }
    document.getElementById("commissioner").textContent = data.name;
    document.getElementById("commissioner").href = "mailto:" + data.email;
  } catch (error) {
    console.error("There was an error fetching data.");
  }
}

window.addEventListener("load", initializePage);
window.addEventListener("resize", changeScreenSizeMain);
