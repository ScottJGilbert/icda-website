//Everything below is for the actual page content and varies by file

function initializeFAQ() {
  let questions = document
    .getElementById("info")
    .getElementsByClassName("question");
  let answers = document
    .getElementById("info")
    .getElementsByClassName("answer");
  questions[0].style.borderRadius = "20px 20px 0 0";
  questions[questions.length - 1].style.borderRadius = "0 0 20px 20px";
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
}

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

async function fetchData() {
  const res = await fetch("/api/fetch-rules/index.php");
  const data = await res.json();
  if (!data.success) {
    throw new Error(data.error);
  }

  const rules = data.data;

  for (const rule of rules) {
    const question = document.createElement("div");
    question.className = "question";
    question.innerHTML = `
      <p class="descriptionText"><b>${rule.name} (Rule ${rule.number})</b></p>
      <img src="/public/images/faqArrow.svg" alt="open/close" />
    `;
    document.getElementById("importantRules").appendChild(question);

    const answer = document.createElement("div");
    answer.className = "answer";
    answer.innerHTML = `
      <p class="descriptionText">${rule.summary}</p>
    `;
    document.getElementById("importantRules").appendChild(answer);
  }
}

window.addEventListener("load", fetchData);
window.addEventListener("load", initializeFAQ);
window.addEventListener("resize", changeScreenSizeMain);
