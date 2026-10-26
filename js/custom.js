(() => {
  const themeStore = (() => {
    const localStorageTheme = localStorage?.getItem("theme") ?? "";
    if (["dark", "light"].includes(localStorageTheme)) {
      return localStorageTheme;
    }
    if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
      return "dark";
    }
    return "light";
  })();

  if (themeStore === "dark") {
    document.documentElement.dataset.theme = "dark";
  } else {
    document.documentElement.dataset.theme = "light";
  }
  window.localStorage.setItem("theme", themeStore);

  const icons = document.querySelectorAll(".toggle-icon");
  icons.forEach((icon) => {
    if (themeStore === "dark") {
      icon.classList.replace("fa-circle", "fa-moon");
    } else {
      icon.classList.replace("fa-circle", "fa-sun");
    }
  });

  const loader = document.getElementById("loader");
  loader.innerHTML =
  `loading... 0%...<br><br>
  qQWww..<br>
  Qww__kkc_<br>
  QqwW5kcmVv33..<br>
  QW5kcmV3IE1jSW5uZXM=<br>
  AaaAWw55k..<br>
  aAnddd...<br>
  Aa___mV3IE1jSWuuu...<br>
  _._-_... 52%..<br>
  _E1jSW5uZXM=<br>
  .... E1Li1jjSW5us.. McI1jjSWww5uzs_<br>
  _---A__.._nnn5Suzzzz... MMmkkCcciIInn__nsss<br>
  IiiNnnz5ss...<br>
  __..___----__..szZXM=.. 99%<br><br>
  loading... 100%...`;

  const updateYear = document.getElementById("year");
  const date = new Date().getFullYear();
  updateYear.innerHTML = date;

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
  const icons = document.querySelectorAll(".toggle-icon");
  const theme = document.documentElement.dataset.theme;

  if (theme === "dark") {
    document.documentElement.dataset.theme = "light";
    window.localStorage.setItem("theme", "light");
    icons.forEach((icon) => {
      icon.classList.replace("fa-moon", "fa-sun");
    });
  } else {
    document.documentElement.dataset.theme = "dark";
    window.localStorage.setItem("theme", "dark");
    icons.forEach((icon) => {
      icon.classList.replace("fa-sun", "fa-moon");
    });
  }
}

function toggleMenu() {
  const mobileMenu = document.getElementById("mobileMenu");
  document.body.classList.toggle("fixed");
  mobileMenu.classList.toggle("hidden");
}
