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
  const startYear = 2018;
  const fullContainer = document.querySelector("#edit");
  fullContainer.innerHTML = "";

  for (const season of archiveData) {
    const division = document.createElement("div");
    division.className = "division";
    const section = document.createElement("section");

    const div = document.createElement("div");
    div.className = "seasonDiv";

    const seasonTitle = document.createElement("h2");
    seasonTitle.className = "title";
    seasonTitle.textContent = `${startYear + season.id} - ${
      startYear + season.id + 1
    }`;
    div.appendChild(seasonTitle);

    const dataFormContainer = document.createElement("div");
    dataFormContainer.className = "dataFormContainer";

    const dataForm = document.createElement("form");
    dataForm.className = "dataForm";

    for (let i = 1; i <= 6; i++) {
      const dataFormDiv = document.createElement("div");

      if (i !== 6) {
        const schoolInput = document.createElement("input");
        schoolInput.type = "text";
        schoolInput.id = season.id + "SchoolInput" + i;
        schoolInput.value = season[`icda_${i}_school`];
        dataFormDiv.appendChild(schoolInput);

        const schoolLabel = document.createElement("label");
        schoolLabel.htmlFor = season.id + "SchoolInput" + i;
        schoolLabel.textContent = `ICDA ${i} School`;
        dataFormDiv.appendChild(schoolLabel);
      }

      const dateInput = document.createElement("input");
      dateInput.type = "date";
      dateInput.id = season.id + "DateInput" + i;

      const dateLabel = document.createElement("label");
      dateLabel.htmlFor = season.id + "DateInput" + i;
      if (i !== 6) {
        dateInput.value = season[`icda_${i}_date`];
        dateLabel.textContent = `ICDA ${i} Date`;
      } else {
        dateInput.value = season.icda_state_date;
        dateLabel.textContent = `ICDA State Date`;
      }
      dataFormDiv.appendChild(dateInput);
      dataFormDiv.appendChild(dateLabel);

      // NEW: wrap inputs into following labels
      for (let j = 0; j < dataFormDiv.children.length - 1; j++) {
        const current = dataFormDiv.children[j];
        const next = dataFormDiv.children[j + 1];
        if (current.tagName === "INPUT" && next?.tagName === "LABEL") {
          next.insertBefore(current, next.firstChild);
        }
      }

      dataForm.appendChild(dataFormDiv);
    }

    const dataSubmitButton = document.createElement("button");
    dataSubmitButton.innerText = "Save Archive Data";
    dataSubmitButton.onclick = () => {
      updateData(season.id);
    };

    dataFormContainer.appendChild(dataForm);
    dataFormContainer.appendChild(dataSubmitButton);
    div.appendChild(dataFormContainer);

    const legislationContainer = document.createElement("div");
    legislationContainer.className = "legislationContainer";
    for (let i = 1; i <= 6; i++) {
      const uploadLegislationDiv = document.createElement("div");
      const uploadLegislationForm = document.createElement("form");
      uploadLegislationForm.id = season.id + "UploadLegislationForm" + i;

      const selectLegislationFile = document.createElement("input");
      selectLegislationFile.name = "legislation";
      selectLegislationFile.type = "file";
      selectLegislationFile.accept = ".pdf";
      uploadLegislationForm.appendChild(selectLegislationFile);

      const selectLegislationLabel = document.createElement("label");
      selectLegislationLabel.htmlFor = season.id + "UploadLegislationForm" + i;
      selectLegislationLabel.innerText = "Upload Legislation";
      uploadLegislationForm.appendChild(selectLegislationLabel);

      // Wrap if needed
      if (selectLegislationFile.nextElementSibling === selectLegislationLabel) {
        selectLegislationLabel.insertBefore(
          selectLegislationFile,
          selectLegislationLabel.firstChild
        );
      }

      uploadLegislationDiv.appendChild(uploadLegislationForm);

      const uploadLegislationButton = document.createElement("button");
      uploadLegislationButton.textContent = "Upload Legislation";
      uploadLegislationButton.onclick = () => {
        uploadLegislation(season.id, i);
      };
      uploadLegislationDiv.appendChild(uploadLegislationButton);

      const deleteLegislationButton = document.createElement("button");
      deleteLegislationButton.textContent = "Delete Legislation";
      deleteLegislationButton.className = "redButton";
      deleteLegislationButton.onclick = () => {
        deleteLegislation(season.id, i);
      };
      uploadLegislationDiv.appendChild(deleteLegislationButton);

      legislationContainer.appendChild(uploadLegislationDiv);
    }
    div.appendChild(legislationContainer);

    const resultsContainer = document.createElement("div");
    resultsContainer.className = "resultsContainer";
    for (let i = 1; i <= 6; i++) {
      const uploadResultsDiv = document.createElement("div");
      const uploadResultsForm = document.createElement("form");
      uploadResultsForm.id = season.id + "UploadResultsForm" + i;

      const selectResultsFile = document.createElement("input");
      selectResultsFile.name = "results";
      selectResultsFile.type = "file";
      selectResultsFile.accept = ".pdf";
      uploadResultsForm.appendChild(selectResultsFile);

      const selectResultsLabel = document.createElement("label");
      selectResultsLabel.htmlFor = season.id + "UploadResultsForm" + i;
      selectResultsLabel.innerText = "Upload Results";
      uploadResultsForm.appendChild(selectResultsLabel);

      // Wrap if needed
      if (selectResultsFile.nextElementSibling === selectResultsLabel) {
        selectResultsLabel.insertBefore(
          selectResultsFile,
          selectResultsLabel.firstChild
        );
      }

      uploadResultsDiv.appendChild(uploadResultsForm);

      const uploadResultsButton = document.createElement("button");
      uploadResultsButton.textContent = "Upload Results";
      uploadResultsButton.onclick = () => {
        uploadResults(season.id, i);
      };
      uploadResultsDiv.appendChild(uploadResultsButton);

      const deleteResultsButton = document.createElement("button");
      deleteResultsButton.textContent = "Delete Results";
      deleteResultsButton.className = "redButton";
      deleteResultsButton.onclick = () => {
        deleteResults(season.id, i);
      };
      uploadResultsDiv.appendChild(deleteResultsButton);

      resultsContainer.appendChild(uploadResultsDiv);
    }
    div.appendChild(resultsContainer);

    section.appendChild(div);
    division.appendChild(section);
    fullContainer.appendChild(division);
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

  const res = await fetch("/api/update-archive-data/index.php", {
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
  } else {
    alert("Archive data updated successfully!");
  }
  fetchData();
}

async function uploadLegislation(archiveId, tournamentId) {
  const formData = new FormData(
    document.getElementById(archiveId + "UploadLegislationForm" + tournamentId)
  );
  formData.append("archiveId", archiveId);
  formData.append("tournamentId", tournamentId);
  const res = await fetch("/api/update-archive-legislation/index.php", {
    method: "POST",
    body: formData,
  });

  const data = await res.json();
  if (!res.ok) {
    alert("There was an error uploading legislation: " + data.error);
  } else {
    alert("Legislation uploaded successfully!");
  }
  fetchData();
}

async function deleteLegislation(archiveId, tournamentId) {
  const res = await fetch(
    "/api/delete-archive-legislation/index.php?archiveId=" +
      archiveId +
      "&tournamentId=" +
      tournamentId,
    {
      method: "DELETE",
    }
  );

  const data = await res.json();
  if (!res.ok) {
    alert("There was an error deleting legislation: " + data.error);
  } else {
    alert("Legislation deleted successfully!");
  }
  fetchData();
}

async function uploadResults(archiveId, tournamentId) {
  const formData = new FormData(
    document.getElementById(archiveId + "UploadResultsForm" + tournamentId)
  );
  formData.append("archiveId", archiveId);
  formData.append("tournamentId", tournamentId);
  const res = await fetch("/api/update-archive-results/index.php", {
    method: "POST",
    body: formData,
  });

  const data = await res.json();
  if (!data.success) {
    alert("There was an error uploading results: " + data.error);
  } else {
    alert("Results uploaded successfully!");
  }
  fetchData();
}

async function deleteResults(archiveId, tournamentId) {
  const res = await fetch(
    "/api/delete-archive-results/index.php?archiveId=" +
      archiveId +
      "&tournamentId=" +
      tournamentId,
    {
      method: "DELETE",
    }
  );

  const data = await res.json();
  if (!data.success) {
    alert("There was an error deleting results: " + data.error);
  } else {
    alert("Results deleted successfully!");
  }
  fetchData();
}

window.addEventListener("load", fetchData);
