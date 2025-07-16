let archiveData = [];

async function fetchData() {
  try {
    const res = await fetch("/api/fetch-archive-data/index.php");
    const data = await res.json();
    if (!data.success) {
      throw new Error(data.error);
    }

    archiveData = data.data;
    displayData();
  } catch (error) {
    console.error("Error fetching archive data: ", error);
  }
}

function displayData() {
  //May need to change depending on what the earliest season loaded in is
  const startYear = 2020;

  const fullContainer = document.querySelector("#edit");
  fullContainer.innerHTML = "";

  for (const season of data) {
    const div = document.createElement("div");
    div.className = "seasonDiv";

    const dataForm = document.createElement("form");

    for (let i = 1; i <= 6; i++) {
      if (i !== 6) {
        const schoolInput = document.createElement("input");
        schoolInput.type = "text";
        schoolInput.id = season.id + "SchoolInput" + i;
        dataForm.appendChild(schoolInput);
      }
      const dateInput = document.createElement("input");
      dateInput.type = "date";
      dateInput.id = season.id + "DateInput" + i;
      dataForm.appendChild(dateInput);
    }

    div.appendChild(dataForm);

    const dataSubmitButton = document.createElement("button");
    dataSubmitButton.value = "Save Archive Data";
    dataSubmitButton.onclick = () => {
      updateData(season.id);
    };

    div.appendChild(dataSubmitButton);

    for (let i = 0; i < 6; i++) {
      const uploadLegislationDiv = document.createElement("div");

      const uploadLegislationForm = document.createElement("form");
      uploadLegislationForm.id = season.id + "UploadLegislationForm" + i;
      const selectLegislationFile = document.createElement("input");
      selectLegislationFile.type = "file";
      selectLegislationFile.accept = ".pdf";
      uploadLegislationForm.appendChild(selectLegislationFile);
      uploadLegislationDiv.appendChild(uploadLegislationForm);

      const uploadLegislationButton = document.createElement("button");
      uploadLegislationButton.value = "Upload Legislation";
      uploadLegislationButton.onclick = () => {
        uploadLegislation(season.id, i);
      };
      uploadLegislationDiv.appendChild(uploadLegislationButton);

      const deleteLegislationButton = document.createElement("button");
      deleteLegislationButton.value = "Upload Legislation";
      deleteLegislationButton.onclick = () => {
        deleteLegislation(season.id, i);
      };
      uploadLegislationDiv.appendChild(deleteLegislationButton);

      div.appendChild(uploadLegislationDiv);
    }

    for (let i = 0; i < 6; i++) {
      const uploadResultsDiv = document.createElement("div");

      const uploadResultsForm = document.createElement("form");
      uploadResultsForm.id = season.id + "UploadLegislationForm" + i;
      const selectResultsFile = document.createElement("input");
      selectResultsFile.type = "file";
      selectResultsFile.accept = ".pdf";
      uploadResultsForm.appendChild(selectResultsFile);
      uploadResultsDiv.appendChild(uploadResultsForm);

      const uploadResultsButton = document.createElement("button");
      uploadResultsButton.value = "Upload Results";
      uploadResultsButton.onclick = () => {
        uploadResults(season.id, i);
      };
      uploadResultsDiv.appendChild(uploadResultsButton);

      const deleteResultsButton = document.createElement("button");
      deleteResultsButton.value = "Upload Results";
      deleteResultsButton.onclick = () => {
        deleteResults(season.id, i);
      };
      uploadResultsDiv.appendChild(deleteResultsButton);

      div.appendChild(uploadResultsDiv);
    }
    fullContainer.appendChild(div);
  }
}

async function updateData(archiveId) {
  const names = [];
  const dates = [];
  for (let i = 1; i <= 6; i++) {
    if (i !== 6) {
      const nameInput = document.getElementById(archiveId + "SchoolInput" + i);
      names.push(nameInput.value);
    }
    const dateInput = document.getElementById(archiveId + "DateInput" + i);
    dates.push(dateInput.value);
  }

  const res = await fetch("/api/update-archive-data", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      names: names,
      dates: dates,
      id: archiveId,
    }),
  });

  const data = await res.json();
  if (!data.success) {
    alert("There was an error updating archive data: " + data.error);
  }
  fetchData();
  alert("Archive data updated successfully!");
}

async function uploadLegislation(archiveId, tournamentId) {
  const formData = document.getElementById(
    archiveId + "UploadLegislationForm" + tournamentId
  );
  const res = await fetch("/api/update-archive-legislation", {
    method: "POST",
    body: { ...formData, archive_id: archiveId, tournament_id: tournamentId },
  });

  const data = await res.json();
  if (!data.success) {
    alert("There was an error uploading legislation: " + data.error);
  }
  fetchData();
  alert("Legislation uploaded successfully!");
}

async function deleteLegislation(archiveId, tournamentId) {
  const res = await fetch("/api/delete-archive-legislation", {
    method: "POST",
    body: JSON.stringify({
      archive_id: archiveId,
      tournament_id: tournamentId,
    }),
  });

  const data = await res.json();
  if (!data.success) {
    alert("There was an error deleting legislation: " + data.error);
  }
  fetchData();
  alert("Legislation deleted successfully!");
}

async function uploadResults(archiveId, tournamentId) {
  const formData = document.getElementById(
    archiveId + "UploadResultsForm" + tournamentId
  );
  const res = await fetch("/api/update-archive-results", {
    method: "POST",
    body: { ...formData, archive_id: archiveId, tournament_id: tournamentId },
  });

  const data = await res.json();
  if (!data.success) {
    alert("There was an error uploading results: " + data.error);
  }
  fetchData();
  alert("Results uploaded successfully!");
}

async function deleteResults(archiveId, tournamentId) {
  const res = await fetch("/api/delete-archive-results", {
    method: "POST",
    body: JSON.stringify({
      archive_id: archiveId,
      tournament_id: tournamentId,
    }),
  });

  const data = await res.json();
  if (!data.success) {
    alert("There was an error deleting results: " + data.error);
  }
  fetchData();
  alert("Results deleted successfully!");
}

window.addEventListener("load", fetchData);
