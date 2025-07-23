async function logout() {
  try {
    const res = await fetch("/api/logout/index.php", {
      method: "POST",
    });
    if (!res.ok) {
      throw new Error("Logout failed");
    }
    window.location.href = "/login";
  } catch (error) {
    console.error("Error during logout:", error);
    alert("An error occurred while logging out. Please try again later.");
  }
}
