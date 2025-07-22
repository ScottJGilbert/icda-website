const rules = [];

async function fetchData() {
  try {
    const res = await fetch("/api/fetch-rules/index.php");
    const data = await res.json();
    if (!data.success) {
      throw new Error(data.error);
    }
    const fetchedRules = data.data;
    rules.length = 0;
    for (const rule of fetchedRules) {
      rules.push({
        id: rules.length,
        name: rule.name,
        number: rule.number,
        summary: rule.summary,
      });

      const ruleDiv = document.createElement("div");
      ruleDiv.className = "rule";
      const ruleForm = document.createElement("form");
      ruleForm.id = "rule" + rule.id;
      ruleForm.innerHTML = `
      <input type="text" placeholder="Name" value=${rule.name} />
      <input type="number" placeholder="Number" value=${rule.number} />
      <input type="text" placeholder="Summary" value=${rule.Summary} />
      `;

      ruleDiv.appendChild(ruleForm);
      ruleDiv.innerHTML += `
      <button onclick="editRule('${rule.id}')">Save</button>
      <button onclick="deleteRule('${rule.id}')">Delete Rule</button>
      `;

      document.getElementById("rules").appendChild(ruleDiv);
    }
  } catch (error) {
    console.error("Error fetching rules:", error);
    alert("An error occurred while fetching rules. Please try again later.");
  }
}

function displayRules() {
  document.getElementById("rules").innerHTML = ""; //Clear displayed rules
  for (const rule of rules) {
    const ruleDiv = document.createElement("div");
    ruleDiv.className = "rule";
    const ruleForm = document.createElement("form");
    ruleForm.id = "rule" + rule.id;
    ruleForm.innerHTML = `
      <label for="${rule.id}Name">Rule Name <span style="color: red">*</span></label>
      <input
        type="text"
        id="${rule.id}Name"
        name="name"
        placeholder="Name"
        value="${rule.name}"
        required
      />
      <label for="${rule.id}Number">Rule Number <span style="color: red">*</span></label>
      <input
        type="number"
        id="${rule.id}Number"
        name="number"
        placeholder="Gaveling Procedure"
        value="${rule.number}"
        required
      />
      <label for="summary"
        >Rule Summary <span style="color: red">*</span></label
      >
      `;

    const textarea = document.createElement("textarea");
    textarea.id = rule.id + "summary";
    textarea.name = "summary";
    textarea.placeholder = "Presiding officers must...";
    textarea.spellcheck = "default";
    textarea.required = true;
    textarea.value = rule.summary;
    ruleForm.appendChild(textarea);

    ruleDiv.appendChild(ruleForm);
    ruleDiv.innerHTML += `
      <button onclick="editRule('${rule.id}')">Save</button>
      <button onclick="deleteRule('${rule.id}')">Delete Rule</button>
      `;

    document.getElementById("rules").appendChild(ruleDiv);
  }
}

async function updateRules() {
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
  const data = Object.fromEntries(formData.entries());

  rules.push({
    id: rules.length,
    name: data.name,
    number: data.number,
    summary: document.querySelector("#summary").value,
  });

  displayRules();

  form.reset();
  document.querySelector("#summary").value = "";
}

async function editRule(ruleId) {
  const form = document.getElementById("rule" + ruleId);
  const formData = new FormData(form);
  const data = Object.fromEntries(formData.entries());

  for (const rule of rules) {
    if (rule.id === ruleId) {
      rule.name = data.name;
      rule.number = data.number;
      rule.summary = document.querySelector("#" + ruleId + "summary").value;
    }
    break;
  }

  displayRules;
}

async function deleteRule(ruleId) {
  for (let i = 0; i < rules.length; i++) {
    const rule = rules[i];
    rule.id = i;
    if (rule.id === ruleId) {
      rules.splice(i, 1);
    }
  }
  displayRules;
}

window.addEventListener("load", fetchData);
