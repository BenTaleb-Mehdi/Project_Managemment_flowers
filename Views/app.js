const removeLinks = () => document.querySelectorAll(".delete");
const aleart_remove = document.querySelector(".aleart_delete");
const no = document.querySelector(".no");
const yes = document.querySelector(".yes");

const tableBody = document.getElementById("productTableBody");

let deleteUrl = "";


const setupDeleteButtons = () => {
  removeLinks().forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      deleteUrl = link.getAttribute("href");
      aleart_remove.classList.add("active");
    });
  });
};

no.addEventListener("click", () => aleart_remove.classList.remove("active"));
yes.addEventListener("click", () => (window.location.href = deleteUrl));


const btn = document.getElementById("submitBtn");
const options = document.querySelector(".options");
const iconDown = document.querySelector(".down");
const iconUp = document.querySelector(".up");
const selectedProductName = document.getElementById("selectedProductName");

btn.addEventListener("click", () => {
  options.classList.toggle("active");
  const isActive = options.classList.contains("active");
  iconDown.style.display = isActive ? "none" : "block";
  iconUp.style.display = isActive ? "block" : "none";
});

document.querySelectorAll(".option").forEach((option) => {
  option.addEventListener("click", () => {
    const catId = option.getAttribute("data-id");
    const catName = option.getAttribute("data-name");

    selectedProductName.textContent = catName;
    options.classList.remove("active");
    iconDown.style.display = "block";
    iconUp.style.display = "none";

    fetch("fetch_product.php?cat_id=" + catId)
      .then((res) => res.text())
      .then((data) => {
        tableBody.innerHTML = data;
        setupDeleteButtons(); 
      })
      .catch((err) => console.error(err));
  });
});


setupDeleteButtons();
