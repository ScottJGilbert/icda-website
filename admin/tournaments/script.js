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

      document.getElementById("date" + i).value = tournament.date;
      document.getElementById("tabroom" + i).value = tournament.tabroom_url;

      if (i !== 6) {
        const select = schoolSelect.cloneNode(true);
        select.id = "schoolSelect" + i;
        select.value = tournament.school_name;
        document.getElementById("schoolSelect" + i).replaceWith(select);

        for (const option of select.options) {
          if (option.text === tournament.school_name) {
            option.selected = true;
            break;
          }
        }
      }

      const contactList = document
        .getElementById("tournament" + i + "Contacts")
        .querySelector(".contactList");

      for (const contact of tournament.contacts) {
        const trimmedName = contact.name.replace(/\s+/g, "");
        contactList.innerHTML += `
        <div class="contact" id="${i + trimmedName}contact">
          <p class="contactName">${contact.name}</p> 
          <p class="contactEmail">(${contact.email})</p>
          <button type="button" onclick="deleteContact(${
            i + contact.name
          }')">Delete Contact</button>
        </div>
        `;
      }
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

async function updateTournament(tournamentId) {
  const form = document.getElementById("tournament" + tournamentId);
  const formData = new FormData(form);

  if (tournamentId !== 6) {
    const schoolSelect = document.getElementById("schoolSelect" + tournamentId);
    formData.school_id = schoolSelect.value;
  } else {
    formData.school_id = -1; // State tournament has a fixed school ID
  }
  const contactList = document
    .getElementById(`tournament${tournamentId}Contacts`)
    .querySelector(".contactList");
  const names = contactList.querySelectorAll(`.contactName`);
  const emails = contactList.querySelectorAll(`.contactEmail`);
  const contacts = [];
  for (let i = 0; i < names.length; i++) {
    contacts.push({
      name: names[i].textContent,
      email: emails[i].textContent.replace(/[()]/g, "").trim(),
    });
  }

  formData.append("contacts", JSON.stringify(contacts));
  formData.append("id", tournamentId);

  try {
    const res = await fetch("/api/update-tournament/index.php", {
      method: "POST",
      body: formData,
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
