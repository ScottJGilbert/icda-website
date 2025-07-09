async function login() {
  const formData = new FormData(document.querySelector("#loginForm"));
  const res = await fetch("/api/login/index.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(Object.fromEntries(formData.entries())),
  });
  
  console.log(formData);
  console.log(JSON.stringify(Object.fromEntries(formData.entries())));

  if (!res.ok) {
    alert("Login failed.");
    window.location.reload();
  }
  
  window.location.reload();
}

function onLoad() {
  const params = new URLSearchParams(window.location.search);
  switch (params.get("code")) {
    case "1":
      document.getElementById("errorOne").style.display = "block";
      document.getElementById("errorTwo").style.display = "none";
      break;
    case "2":
      document.getElementById("errorOne").style.display = "none";
      document.getElementById("errorTwo").style.display = "block";
      break;
    default:
      document.getElementById("errorOne").style.display = "none";
      document.getElementById("errorTwo").style.display = "none";
  }
}

window.onload = onLoad; // Call onLoad when the page loads
