async function fetchData() {
  try {
    const res = await fetch("/api/fetch-schools/index.php");
    const data = await res.json();
    if (!data.success) {
      throw new Error(data.error);
    }
    const schools = data.data;
    document.getElementById("schools").innerHTML = ""; // Clear existing schools
    for (const school of schools) {
      const schoolDiv = document.createElement("div");
      schoolDiv.className = "school";
      const schoolForm = document.createElement("form");
      schoolForm.id = "school" + school.id;
      schoolForm.innerHTML = `
      <input type="text" id="${
        "school" + school.id + "name"
      }" name="name" placeholder="Name" value="${school.name}" />
      <label for=id="${
        "school" + school.id + "name"
      }">Name <span style="color: red">*</span></label>
      <input type="file" id="${
        "school" + school.id + "image"
      }" name="image" accept="image/*" />
      <label for="${"school" + school.id + "image"}">Logo</label>
      <input type="checkbox" id="${
        "member" + school.id + "deletePhoto"
      }" name="deleteImage" />
      <label for="${"member" + school.id + "deletePhoto"}">Delete Photo</label>
      `;

      schoolDiv.appendChild(schoolForm);
      schoolDiv.innerHTML += `
      <button onclick="editSchool('${school.id}')">Save</button>
      <button onclick="deleteSchool('${school.id}')">Delete School</button>
      `;

      document.getElementById("schools").appendChild(schoolDiv);
    }
  } catch (error) {
    console.error("Error fetching schools:", error);
    alert("An error occurred while fetching schools. Please try again later.");
  }

  try {
    const res = await fetch("/api/fetch-all-oversight/index.php");
    const data = await res.json();
    if (!data.success) {
      throw new Error(data.error);
    }
    const oversightNames = [
      "President",
      "Secretary",
      "Treasurer",
      "Executive",
      "Technology",
      "Membership/Training",
      "At-Large",
    ];
    const oversight = data.data;
    document.getElementById("oversight").innerHTML = ""; // Clear existing members
    for (const member of oversight) {
      const memberDiv = document.createElement("div");
      member.className = "member";
      const memberForm = document.createElement("form");
      memberForm.id = "member" + member.id;
      memberForm.innerHTML = `
      <p>${oversightNames[member.id - 1]}:</p>
      <input type="text" id="${
        "member" + member.id + "name"
      }" name="name" placeholder="Name" value="${member.name}" required />
      <label for="${
        "member" + member.id + "name"
      }">Name <span style="color: red">*</span></label>
      <input type="email" id="${
        "member" + member.id + "email"
      }" name="email" placeholder="Email" value="${member.email}" />
      <label for="email">Email</label>
      <input type="file" id="${
        "member" + member.id + "photo"
      }" name="image" accept="image/*" />
      <label for="file" id="${"member" + member.id + "photo"}">Portrait</label>
      <input type="checkbox" id="${
        "member" + member.id + "deletePhoto"
      }" name="deleteImage" />
      <label for="${"member" + member.id + "deletePhoto"}">Delete Photo</label>
      `;

      memberDiv.appendChild(memberForm);
      memberDiv.innerHTML += `
      <button onclick="editMember('${member.id}')">Save</button>
      `;

      document.getElementById("oversight").appendChild(memberDiv);
    }
  } catch (error) {
    console.error("Error fetching schools:", error);
    alert(
      "An error occurred while fetching oversight. Please try again later."
    );
  }
}

async function addNewSchool() {
  const form = document.getElementById("new-school-form");
  const formData = new FormData(form);
  try {
    const res = await fetch("/api/new-school/index.php", {
      method: "POST",
      body: formData,
    });
    const data = await res.json();
    if (!data.success) {
      throw new Error(data.error);
    }
    fetchData();
    alert("School added successfully!");
  } catch (error) {
    console.error("Error adding school:", error);
    alert(
      "An error occurred while adding this school. Please try again later."
    );
  }
}

async function editSchool(schoolId) {
  const form = document.getElementById("school" + schoolId);
  const formData = new FormData(form);
  formData.append("id", schoolId);
  formData.append(
    "deleteImage",
    document.getElementById("school" + schoolId + "deletePhoto").checked
  );

  try {
    const res = await fetch("/api/update-school/index.php", {
      method: "POST",
      body: formData,
    });
    const data = await res.json();
    if (!data.success) {
      throw new Error(data.error);
    }
    fetchData();
    alert("School updated successfully!");
  } catch (error) {
    console.error("Error editing school:", error);
    alert(
      "An error occurred while editing the school. Please try again later."
    );
  }
}

async function deleteSchool(schoolId) {
  if (!confirm("Are you sure you want to delete this school?")) {
    return;
  }

  try {
    const res = await fetch("/api/delete-school/index.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ id: schoolId }),
    });
    const data = await res.json();
    if (!data.success) {
      throw new Error(data.error);
    }
    fetchData();
    alert("School deleted successfully!");
  } catch (error) {
    console.error("Error deleting school:", error);
    alert(
      "An error occurred while deleting the school. Please try again later."
    );
  }
}

async function editMember(memberId) {
  const form = document.getElementById("member" + memberId);
  const formData = new FormData(form);
  formData.append("id", memberId);
  formData.append(
    "deleteImage",
    document.getElementById("member" + memberId + "deletePhoto").checked
  );

  try {
    const res = await fetch("/api/update-oversight/index.php", {
      method: "POST",
      body: formData,
    });
    const data = await res.json();
    if (!data.success) {
      throw new Error(data.error);
    }
    fetchData();
    alert("Member updated successfully!");
  } catch (error) {
    console.error("Error editing member:", error);
    alert(
      "An error occurred while editing the member. Please try again later."
    );
  }
}

fetchData();
