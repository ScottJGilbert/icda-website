const formData = new FormData(document.getElementById("login-form"));

async function postData() {
  const res = await fetch("/api/login", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(formData),
  });

  if (!res.ok) {
    alert("Failed to update.");
  } else {
    alert("Saved!");
  }
}

function onLoad() {
  const params = new URLSearchParams(window.location.search);
  switch (params.get("code")) {
    case "1":
      document.getElementById("errorOne").style.display = "block";
      break;
    case "2":
      document.getElementById("errorTwo").style.display = "block";
      break;
    default:
      document.getElementById("errorOne").style.display = "none";
      document.getElementById("errorTwo").style.display = "none";
  }
}
