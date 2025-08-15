async function fetchData() {
  try {
    const res = await fetch("/api/fetch-users/index.php");
    const data = await res.json();
    if (!data.success) {
      throw new Error(data.error);
    }
    const users = data.data;
    for (const user of users) {
      const userDiv = document.createElement("div");
      userDiv.className = "user";
      userDiv.id = user.uuid;
      userDiv.innerHTML = `
      <div style:"display: flex; flex-wrap: wrap; gap: 5px;">
        <p><b>UUID</b>: ${user.uuid}</p>
        <p><b>Name</b>: ${user.name}</p>
        <p><b>Username</b>: ${user.username}</p>
        <p><b>Access Level</b>: ${user.access_level}</p>
      </div>
      <button class="redButton" onclick="deleteUser('${user.uuid}')">Delete User</button>
    `;
      document.getElementById("currentUsers").appendChild(userDiv);
    }
  } catch (error) {
    console.error("Error fetching users:", error);
    alert("An error occurred while fetching users. Please try again later.");
  }

  try {
    const res = await fetch("/api/fetch-sessions/index.php");
    const data = await res.json();
    if (!data.success) {
      throw new Error(data.error);
    }
    const sessions = data.data;
    for (const session of sessions) {
      const sessionDiv = document.createElement("div");
      sessionDiv.className = "user";
      sessionDiv.id = session.session_id;
      sessionDiv.innerHTML = `
      <p>Session ID: ${session.session_id}</p>
      <div style="display: flex; gap: 5px; flex-wrap: wrap;">
        <p><b>User UUID</b>: ${session.user_uuid}</p>
        <p><b>IP Address</b>: ${session.ip_address}</p>
        <p><b>User Agent</b>: ${session.user_agent}</p>
      </div>
      <div style="display: flex; gap: 5px; flex-wrap: wrap;">
        <p><b>Created At</b>: ${session.created_at}</p>
        <p><b>Last Seen</b>: ${session.last_seen}</p>
      </div>
      <button class="redButton" onclick="terminateSession('${session.session_id}')">Terminate Session</button>
    `;
      document.getElementById("currentSessions").appendChild(sessionDiv);
    }
  } catch (error) {
    console.error("Error fetching users:", error);
    alert("An error occurred while fetching sessions. Please try again later.");
  }
}

async function terminateSession(sessionId) {
  const res = await fetch("/api/terminate-session/index.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ sessionId: sessionId }),
  });

  if (!res.ok) {
    alert("Failed to terminate session: ", res.error);
  } else {
    alert("Saved!");
    document.getElementById(sessionId).remove();
  }
}

async function deleteUser(uuid) {
  const res = await fetch("/api/delete-user/index.php?uuid=" + uuid, {
    method: "DELETE",
  });

  if (!res.ok) {
    alert("Failed to delete user.");
  } else {
    alert("Saved!");
    document.getElementById(uuid).remove();
  }
}

async function newUser() {
  if (
    document.getElementById("password").value !==
    document.getElementById("confirmPassword").value
  ) {
    alert("Passwords do not match!");
    return;
  }
  const formData = new FormData(document.getElementById("new-user-form"));

  const res = await fetch("/api/new-user/index.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(Object.fromEntries(formData.entries())),
  });

  if (!res.ok) {
    alert("Failed to create new user.");
  } else {
    alert("Saved!");
    fetchData();
  }
}

function newConstitution() {
  const form = document.getElementById("newConstitution");
  const formData = new FormData(form);

  fetch("/api/update-constitution/index.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Upload failed");
      }
      return response.json(); // or response.text() if your API doesn't return JSON
    })
    .then((data) => {
      console.log("Success:", data);
      alert("Upload successful!");
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Upload failed");
    });
}

window.addEventListener("load", fetchData);
