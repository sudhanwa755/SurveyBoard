// Apply theme on page load
document.addEventListener("DOMContentLoaded", function () {
  const theme = localStorage.getItem("theme");
  if (theme === "dark") {
    document.body.classList.add("dark-mode");
  }
});

// Toggle between light and dark mode
function toggleMode() {
  const isDark = document.body.classList.toggle("dark-mode");
  localStorage.setItem("theme", isDark ? "dark" : "light");

  // Optional: Update any chart visuals
  if (typeof updateCharts === "function") updateCharts();
}
