(() => {
  let updateYear = document.getElementById("year");
  let date = new Date().getFullYear();
  updateYear.innerHTML = date;

  const prefersDarkMode = window.matchMedia("(prefers-color-scheme: dark)").matches;
  const icons = document.querySelectorAll(".toggle-icon");

  const theme = document.documentElement.dataset.theme ?? (prefersDarkMode ? "dark" : "light");
  icons.forEach((icon) => {
    if (theme === "dark") {
      icon.classList.replace("fa-circle", "fa-moon");
    } else {
      icon.classList.replace("fa-circle", "fa-sun");
    }
  });

  const cookieDetails = document.querySelector('details');
  const cookieIcons = document.querySelectorAll(".cookie-details");
  cookieDetails.addEventListener('toggle', (event) => {
    cookieIcons.forEach((cookieIcon) => {
      if (cookieDetails.open) {
        cookieIcon.classList.replace("fa-cookie", "fa-cookie-bite");
      } else {
        cookieIcon.classList.replace("fa-cookie-bite", "fa-cookie");
      }
    });
  });

})();

function themeToggle() {
  const prefersDarkMode = window.matchMedia("(prefers-color-scheme: dark)").matches;
  const icons = document.querySelectorAll(".toggle-icon");
  const theme = document.documentElement.dataset.theme ?? (prefersDarkMode ? "dark" : "light");

  if (theme === "dark") {
    document.documentElement.dataset.theme = "light";
    icons.forEach((icon) => {
      icon.classList.replace("fa-moon", "fa-sun");
    });
  } else {
    document.documentElement.dataset.theme = "dark";
    icons.forEach((icon) => {
      icon.classList.replace("fa-sun", "fa-moon");
    });
  }
}
