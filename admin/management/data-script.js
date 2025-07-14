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
      <p>UUID: ${user.uuid}</p>
      <p>Name: ${user.name}</p>
      <p>Username: ${user.username}</p>
      <p>Access Level: ${user.access_level}</p>
      <button onclick="deleteUser('${user.uuid}')">Delete User</button>
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
      <p>User UUID: ${session.user_uuid}</p>
      <p>IP Address: ${session.ip_address}</p>
      <p>User Agent: ${session.user_agent}</p>
      <p>Created At: ${session.created_at}</p>
      <p>Last Seen: ${session.last_seen}</p>
      <button onclick="terminateSession('${session.session_id}')">Terminate Session</button>
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
    body: JSON.stringify(sessionId),
  });

  if (!res.success) {
    alert("Failed to terminate session: ", res.error);
  } else {
    alert("Saved!");
    document.getElementById(sessionId).remove();
  }
}

async function deleteUser(uuid) {
  const res = await fetch("/api/delete-user/index.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(uuid),
  });

  if (!res.success) {
    alert("Failed to delete user: ", res.error);
  } else {
    alert("Saved!");
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

  if (!res.success) {
    alert("Failed to create new user: ", res.error);
  } else {
    alert("Saved!");
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

fetchData();
