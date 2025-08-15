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
      document.getElementById("tabroom" + i).value = tournament.tabroom;

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
    option.id = "school" + school.id;

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
  const contactList = document
    .getElementById("tournament" + tournamentId + "Contacts")
    .querySelector(".contactList");
  contactList.innerHTML += `
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
    for (const option of schoolSelect.options) {
      if (option.selected) {
        formData.append("schoolId", option.id.slice(6));
      }
    }
  } else {
    formData.append("schoolId", 1); // State tournament has a fixed school ID
  }
  const contactList = document
    .getElementById(`tournament${tournamentId}Contacts`)
    .querySelector(".contactList");
  const htmlNames = contactList.querySelectorAll(`.contactName`);
  const htmlEmails = contactList.querySelectorAll(`.contactEmail`);
  const names = [];
  const emails = [];
  for (let i = 0; i < htmlNames.length; i++) {
    names.push(htmlNames[i].textContent.trim());
    emails.push(htmlEmails[i].textContent.replace(/[()]/g, "").trim());
  }

  // You can't send arrays directly in FormData; you need to append each value separately
  names.forEach((name) => formData.append("contactNames[]", name));
  emails.forEach((email) => formData.append("contactEmails[]", email));

  formData.append("id", tournamentId);
  formData.append(
    "deleteLegislation",
    document.getElementById("deleteLegislation" + tournamentId).checked
  );
  formData.append(
    "deleteResults",
    document.getElementById("deleteResults" + tournamentId).checked
  );

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
    window.location.reload();
  } catch (error) {
    console.error("Error editing tournament:", error);
    alert(
      "An error occurred while updating the tournament. Please try again later."
    );
  }
}

window.addEventListener("load", fetchData);
