async function fetchData() {
  try {
    const res = await fetch("/api/fetch-rules/index.php");
    const data = await res.json();
    if (!data.success) {
      throw new Error(data.error);
    }
    const fetchedRules = data.data;

    document.getElementById("rules").innerHTML = ""; // Clear existing rules
    for (const rule of fetchedRules) {
      const ruleDiv = document.createElement("div");
      ruleDiv.className = "rule";
      const ruleForm = document.createElement("form");
      ruleForm.id = "rule" + rule.id;
      ruleForm.className = "ruleForm";
      ruleForm.innerHTML = `
      <div>
        <label for="${rule.id}Name">
          <input type="text" id="${rule.id}Name" name="name" placeholder="Name" value="${rule.name}" required />
          Rule Name <span style="color: red">*</span>
        </label>
        <label for="${rule.id}Number">
          <input type="number" id="${rule.id}Number" name="number" placeholder="12" value="${rule.number}" required />
          Rule Number <span style="color: red">*</span>
        </label>
      </div>
      `;

      const summaryLabel = document.createElement("label");
      summaryLabel.htmlFor = "summary";

      const textarea = document.createElement("textarea");
      textarea.id = rule.id + "summary";
      textarea.name = "summary";
      textarea.placeholder = "Presiding officers must...";
      textarea.spellcheck = "default";
      textarea.defaultValue = rule.summary;
      summaryLabel.appendChild(textarea);

      summaryLabel.innerHTML +=
        'Rule Summary <span style="color: red">*</span>';
      ruleForm.appendChild(summaryLabel);

      ruleDiv.appendChild(ruleForm);
      ruleDiv.innerHTML += `
      <button class="redButton" onclick="deleteRule(${rule.id})">Delete Rule</button>
      `;

      document.getElementById("rules").appendChild(ruleDiv);
    }
  } catch (error) {
    console.error("Error fetching rules:", error);
    alert("An error occurred while fetching rules. Please try again later.");
  }
}

async function updateRules() {
  const rules = [];
  const ruleDivs = document.querySelectorAll(".rule");
  for (const ruleDiv of ruleDivs) {
    const ruleForm = ruleDiv.querySelector("form");
    const name = ruleForm.querySelector("input[name='name']").value.trim();
    const number = ruleForm.querySelector("input[name='number']").value.trim();
    const summary = ruleForm
      .querySelector("textarea[name='summary']")
      .value.trim();
    if (name && number && summary) {
      rules.push({
        id: ruleForm.id.replace("rule", ""),
        name: name,
        number: parseInt(number, 10),
        summary: summary,
      });
    }
  }

  try {
    const res = await fetch("/api/update-rules/index.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ list: rules }),
    });

    const data = await res.json();
    if (!data.success) {
      throw new Error(data.error);
    }
    fetchData();
    alert("Rules updated successfully!");
  } catch (error) {
    console.error("Error updating rules:", error);
    alert("An error occurred while updating rules. Please try again later.");
  }
}

function addRule() {
  const form = document.getElementById("add-rule");
  const formData = new FormData(form);
  const rule = Object.fromEntries(formData.entries());
  const ruleDivs = document.querySelectorAll(".rule");
  rule.id = ruleDivs.length + 1;
  rule.summary = document.querySelector("#summary").value.trim();

  const ruleDiv = document.createElement("div");
  ruleDiv.className = "rule";
  const ruleForm = document.createElement("form");
  ruleForm.id = "rule" + rule.id;
  ruleForm.innerHTML = `
    <label for="${rule.id}Name">Rule Name <span style="color: red">*</span></label>
    <input type="text" id="${rule.id}Name" name="name" placeholder="Name" value="${rule.name}" required />
    <label for="${rule.id}Number">Rule Number <span style="color: red">*</span></label>
    <input type="number" id="${rule.id}Number" name="number" placeholder="Gaveling Procedure" value="${rule.number}" required />
    <label for="summary">Rule Summary <span style="color: red">*</span></label>
    `;

  const textarea = document.createElement("textarea");
  textarea.id = rule.id + "summary";
  textarea.name = "summary";
  textarea.placeholder = "Presiding officers must...";
  textarea.spellcheck = "default";
  textarea.defaultValue = rule.summary;
  ruleForm.appendChild(textarea);

  ruleDiv.appendChild(ruleForm);
  ruleDiv.innerHTML += `
    <button onclick="deleteRule(${rule.id})">Delete Rule</button>
    `;

  document.getElementById("rules").appendChild(ruleDiv);

  form.reset();
  document.querySelector("#summary").value = "";
}

async function deleteRule(ruleId) {
  const ruleDivs = document.querySelectorAll(".rule");
  for (const ruleDiv of ruleDivs) {
    const ruleForm = ruleDiv.querySelector("form");
    if (ruleForm.id === "rule" + ruleId) {
      ruleDiv.remove();
      break;
    }
  }
}

window.addEventListener("load", fetchData);
