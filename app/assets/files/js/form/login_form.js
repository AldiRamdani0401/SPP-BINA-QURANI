window.addEventListener("DOMContentLoaded", () => {
  // == Email ==
  const emailElement = document?.getElementById("email");
  const emailLabel = document?.getElementById("email-label");
  emailElement?.addEventListener("focus", () => {
    emailLabel.classList.remove("font-medium");
    emailLabel.classList.add("font-bold");
  });
  emailElement?.addEventListener("blur", () => {
    emailLabel.classList.remove("font-bold");
    emailLabel.classList.add("font-medium");
  });

  // == Password ==
  const passwordElement = document.getElementById("password");
  const passwordLabel = document.getElementById("password-label");
  passwordElement.addEventListener("focus", () => {
    passwordLabel.classList.remove("font-medium");
    passwordLabel.classList.add("font-bold");
  });
  passwordElement.addEventListener("blur", () => {
    passwordLabel.classList.remove("font-bold");
    passwordLabel.classList.add("font-medium");
  });
});
