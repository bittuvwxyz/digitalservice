const menuBtn = document.querySelector(".menu-btn");
const navLinks = document.querySelector(".nav-links");

if (menuBtn && navLinks) {
  menuBtn.addEventListener("click", () => {
    navLinks.classList.toggle("open");
  });
}

const contactForm = document.querySelector("#contactForm");
if (contactForm) {
  contactForm.addEventListener("submit", (event) => {
    event.preventDefault();
    const messageBox = document.querySelector("#formStatus");
    if (messageBox) {
      messageBox.textContent =
        "Thank you! Your request has been received. We will contact you soon.";
    }
    contactForm.reset();
  });
}
