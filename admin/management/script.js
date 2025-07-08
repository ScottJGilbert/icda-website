async function postData() {
  const formData = new FormData(document.getElementById("new-user-form"));

  const res = await fetch("/api/new-user", {
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
