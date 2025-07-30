async function fetchData() {
  //May need to change depending on what the earliest season loaded in is
  const startYear = 2018;
  const seasonString = window.location.pathname.split("/")[2];
  const seasonStartYear = parseInt(seasonString.slice(0, 5));

  try {
    const res = await fetch(
      `/api/fetch-season-data/index.php?id=${seasonStartYear - startYear}`
    );
    const data = await res.json();
    if (!data.success) {
      throw new Error(data.error);
    }

    const seasonData = data.data;
    displayData(seasonData);
  } catch (error) {
    console.error("Error fetching season data: ", error);
  }
}

function displayData(seasonData) {
  document.getElementById("icda1Name").textContent = seasonData.icda_1_school;
  document.getElementById("icda1Date").textContent = seasonData.icda_1_date;
  document.getElementById("icda2Name").textContent = seasonData.icda_2_school;
  document.getElementById("icda2Date").textContent = seasonData.icda_2_date;
  document.getElementById("icda3Name").textContent = seasonData.icda_3_school;
  document.getElementById("icda3Date").textContent = seasonData.icda_3_date;
  document.getElementById("icda4Name").textContent = seasonData.icda_4_school;
  document.getElementById("icda4Date").textContent = seasonData.icda_4_date;
  document.getElementById("icda5Name").textContent = seasonData.icda_5_school;
  document.getElementById("icda5Date").textContent = seasonData.icda_5_date;
  document.getElementById("icdaStateDate").textContent =
    seasonData.icda_state_date;

  for (let i = 1; i <= 5; i++) {
    document.getElementById(`icda${i}Legislation`).hidden =
      !seasonData.legislationFiles[i - 1];
    document.getElementById(`icda${i}Results`).hidden =
      !seasonData.resultsFiles[i - 1];
  }

  document.getElementById("icdaStateLegislation").hidden =
    !seasonData.legislationFiles[5];
  document.getElementById("icdaStateResults").hidden =
    !seasonData.resultsFiles[5];

  document.title = `${window.location.pathname.split("/")[2]} | ICDA`;
  document.getElementById("season").textContent = `${
    window.location.pathname.split("/")[2]
  }`;
}

window.addEventListener("load", fetchData);
