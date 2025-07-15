async function fetchData() {
  try {
    const res = await fetch("/api/fetch-schools/index.php");
    const data = await res.json();
    if (!data.success) {
      throw new Error(data.error);
    }
    const schools = data.data;

    const res2 = await fetch("/api/fetch-coaches");
    const data2 = await res2.json();
    if (!data2.success) {
      throw new Error(data2.error);
    }
    const coaches = data2.data;
    for (const school of schools) {
      const schoolElement = document.createElement("ul");
      schoolElement.innerHTML = `
        <b>${school.name}</b>
        <img src="${school.image_url}" alt="${school.name}" />
      `;
      const coaches = document.createElement("div");
      for (const coach of coaches) {
        if (coach.school_id === school.id) {
          const coachElement = document.createElement("a");
          coachElement.textContent = coach.name;
          coachElement.href = "mailto:" + coach.email;
          coaches.appendChild(coach);
        }
      }
      schoolElement.appendChild(coaches);
      document.getElementById("list").appendChild(schoolElement);
    }
  } catch (error) {
    console.error("There was an error fetching oversight members: ", error);
  }
}

fetchData();
