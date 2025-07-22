async function fetchData() {
  const schoolSelect = await fetchSchoolDropdown();

  for (let i = 1; i <= 6; i++) {
    try {
      const res = await fetch("/api/fetch-tournament/index.php?id=" + i);
      const data = await res.json();
      if (!data.success) {
        throw new Error(data.error);
      }
      const tournament = data.data;
      const tournamentDiv = document.createElement("div");

      const tournamentForm = document.createElement("form");
      tournamentForm.id = "tournament" + i;
      tournamentForm.className = "tournament";

      tournamentForm.innerHTML = `
      <p>ICDA ${tournament.id === 6 ? "State" : tournament.id}</p>
      <input type="date" name="tournament_date" placeholder="Date" value="${
        tournament.date
      }" />
      <input type="url" name="tabroom" placeholder="Tabroom" value="${
        tournament.tabroom
      }" />
      <input type="file" name="legislation" accept=".pdf" />
      <input type="file" name="results" accept=".pdf" />
      `;
      if (i !== 6) {
        const select = schoolSelect.cloneNode(true);
        select.id = "schoolSelect" + i;
        select.value = tournament.school_name;
        tournamentForm.appendChild(select);
      }

      const contactsDiv = document.createElement("div");
      contactsDiv.className = "contacts";
      contactsDiv.id = "tournament" + i + "Contacts";

      for (const contact of tournament.contacts) {
        const trimmedName = contact.name.replace(/\s+/g, "");
        contactsDiv.innerHTML += `
        <div class="contact" id="${i + trimmedName}contact">
          <p class="contactName">${contact.name}</p> 
          <p class="contactEmail">(${contact.email})</p>
          <button type="button" onclick="deleteContact(${
            i + contact.name
          }')">Delete Contact</button>
        </div>
        `;
      }

      contactsDiv.innerHTML += `
      <input type="text" id=${
        i + "contact_name"
      } placeholder="Contact Name" name="contact_name" />
      <input type="email" id=${
        i + "contact_email"
      } placeholder="Contact Email" name="contact_email" />
      <button type="button" onclick="addContact(${i})">Add Contact</button>
      `;
      tournamentForm.appendChild(contactsDiv);

      editButton = document.createElement("button");
      editButton.type = "button";
      editButton.innerText = "Save";
      editButton.onclick = () => editTournament(i);
      tournamentDiv.appendChild(editButton);

      tournamentDiv.appendChild(tournamentForm);
      document.getElementById("tournamentsDiv").appendChild(tournamentDiv);
    } catch (error) {
      console.error("Error fetching tournament :", error);
      alert(
        "An error occurred while fetching tournaments. Please try again later."
      );
    }
  }
}

async function fetchSchoolDropdown() {
  const res = await fetch("/api/fetch-schools/index.php");
  const data = await res.json();
  if (!data.success) {
    throw new Error(data.error);
  }
  const schools = data.data;

  const schoolSelect = document.createElement("select");
  schoolSelect.className = "schoolSelect";

  for (const school of schools) {
    const option = document.createElement("option");
    option.text = school.name;

    schoolSelect.appendChild(option);
  }

  return schoolSelect;
}

function addContact(tournamentId) {
  const nameInput = document.getElementById(tournamentId + "contact_name");
  const emailInput = document.getElementById(tournamentId + "contact_email");
  const name = nameInput.value.trim();
  const email = emailInput.value.trim();

  const trimmedName = name.replace(/\s+/g, "");

  if (!name || !email) {
    alert("Please enter both name and email.");
    return;
  }
  const contactsDiv = document.getElementById(
    "tournament" + tournamentId + "Contacts"
  );
  contactsDiv.innerHTML += `
  <div class="contact" id="${tournamentId + trimmedName}contact">
    <p class="contactName">${name}</p>
    <p class="contactEmail">(${email})</p>
    <button type="button" onclick="deleteContact('${
      tournamentId + trimmedName + "contact"
    }')">Delete Contact</button>
  </div>
  `;
}

function deleteContact(contact) {
  const contactsDiv = document.getElementById(contact);
  if (contactsDiv) {
    contactsDiv.remove();
  }
}

async function editTournament(tournamentId) {
  const form = document.getElementById("tournament" + tournamentId);
  const formData = new FormData(form);
  const data = Object.fromEntries(formData.entries());

  if (tournamentId !== 6) {
    const schoolSelect = document.getElementById("schoolSelect" + tournamentId);
    data.school_id = schoolSelect.value;
  } else {
    data.school_id = -1; // State tournament has a fixed school ID
  }
  const contactsDiv = document.getElementById(
    `tournament${tournamentId}Contacts`
  );
  const names = contactsDiv.querySelectorAll(`.contactName`);
  const emails = document.querySelectorAll(`.contactEmail`);
  const contacts = [];
  for (let i = 0; i < names.length; i++) {
    contacts.push({
      name: names[i].textContent,
      email: emails[i].textContent.replace(/[()]/g, "").trim(),
    });
  }

  try {
    const res = await fetch("/api/edit-tournament/index.php", {
      method: "POST",
      body: { id: tournamentId, contacts: contacts, ...data },
    });
    const result = await res.json();
    if (!result.success) {
      throw new Error(result.error);
    }
    alert("Tournament updated successfully.");
  } catch (error) {
    console.error("Error editing tournament:", error);
    alert(
      "An error occurred while updating the tournament. Please try again later."
    );
  }
}

window.addEventListener("load", fetchData);
