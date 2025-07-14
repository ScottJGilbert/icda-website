let seasonData = [];

async function fetchData() {
  //May need to change depending on what the earliest season loaded in is
  const startYear = 2020;
  const seasonString = window.location.pathname.split("/")[1];
  const seasonStartYear = int(seasonString.slice(0, 5));

  try {
    const res = await fetch(
      `/api/fetch-season-data/index.php?${seasonStartYear - startYear}`
    );
    const data = await res.json();
    if (!data.success) {
      throw new Error(data.error);
    }

    seasonData = data.data;
    displayData();
  } catch (error) {
    console.error("Error fetching season data: ", error);
  }
}

function displayData() {
  document.getElementById("icda1Name").textContent = data.icda_1_school;
  document.getElementById("icda1Date").textContent = data.icda_1_date;
  document.getElementById("icda2Name").textContent = data.icda_2_school;
  document.getElementById("icda2Date").textContent = data.icda_2_date;
  document.getElementById("icda3Name").textContent = data.icda_3_school;
  document.getElementById("icda3Date").textContent = data.icda_3_date;
  document.getElementById("icda4Name").textContent = data.icda_4_school;
  document.getElementById("icda4Date").textContent = data.icda_4_date;
  document.getElementById("icda5Name").textContent = data.icda_5_school;
  document.getElementById("icda5Date").textContent = data.icda_5_date;
  document.getElementById("icdaStateDate").textContent = data.icda_state_date;

  document.title = `${window.location.pathname.split("/")[1]} | ICDA`;
}

fetchData();
