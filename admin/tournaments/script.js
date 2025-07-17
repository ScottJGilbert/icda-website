async function fetchData() {
  const schoolSelect = await fetchSchoolDropdown();

  for (const i = 1; i <= 6; i++) {
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
        tournament.link
      }" />
      `;
      if (i !== 6) {
        const select = schoolSelect.cloneNode(true);
        select.id = "schoolSelect" + i;
        select.value = tournament.school_name;
        tournamentForm.appendChild(select);
      }

      const contactsDiv = document.createElement("div");
      contactsDiv.className = "contacts";

      for (const contact of tournament.contacts) {
        contactsDiv.innerHTML += `
        <div id="${i + contact.name}contact" class="contact">
          <p class=${"contactName"} id=${i + contact.name + "contactName"}>${
          contact.name
        }</p> 
          <p class=${"contactEmail"} id=${i + contact.name + "contactEmail"}>(${
          contact.email
        })</p>
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

      tournamentDiv.appendChild(tournamentForm);
      document.getElementById("tournaments").appendChild(tournamentDiv);
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
  if (!name || !email) {
    alert("Please enter both name and email.");
    return;
  }
  const contactsDiv = document.querySelector(
    `#tournament${tournamentId} .contacts`
  );
  contactsDiv.innerHTML += `
  <p class="contactName" id=${name + "contactName"}>${name}</p>
  <p class="contactEmail" id=${name + "contactEmail"}>(${email})</p>
  `;
}

function deleteContact(contact) {
  const contactsDiv = document.querySelector(`#${contact}contact`);
  if (contactsDiv) {
    contactsDiv.remove();
  }
}

async function editTournament(tournamentId) {
  const form = document.getElementById("tournament" + tournamentId);
  const formData = new FormData(form);
  const data = Object.fromEntries(formData.entries());

  if (i !== 6) {
    const schoolSelect = document.getElementById("schoolSelect" + tournamentId);
    data.school_id = schoolSelect.value;
  } else {
    data.school_id = -1; // State tournament has a fixed school ID
  }

  const names = document.querySelectorAll(`.${tournamentId}contactName`);
  const emails = document.querySelectorAll(`.${tournamentId}contactEmail`);
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
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id: tournamentId, contacts: contacts, ...data }),
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
