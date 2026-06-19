const whatsappNumber = "5492604598704";

const products = [
  { category: "Cargadores", title: "Cargador USB-C 20W", image: "CARGADOR.jpg" },
  { category: "Fundas", title: "Fundas iPhone 15 Pro", image: "FUNDAS (5).jpg" },
  { category: "Fundas", title: "Fundas iPhone 17", image: "FUNDAS (6).jpg" },
  { category: "Fundas", title: "Fundas iPhone 13 Pro", image: "FUNDAS (13).jpg" },
  { category: "Fundas", title: "Fundas iPhone 13", image: "FUNDAS.jpg" },
  { category: "Fundas", title: "Fundas iPhone 14 Pro Max", image: "FUNDAS (8).jpg" },
  { category: "Fundas", title: "Fundas iPhone 14 Pro", image: "FUNDAS (7).jpg" },
  { category: "Fundas", title: "Fundas iPhone 13 Pro Max", image: "FUNDAS (9).jpg" },
  { category: "Fundas", title: "Fundas iPhone 15", image: "FUNDAS (10).jpg" },
  { category: "Fundas", title: "Fundas iPhone 15 colores", image: "FUNDAS (11).jpg" },
  { category: "Fundas", title: "Fundas iPhone 16", image: "FUNDAS (1).jpg" },
  { category: "Fundas", title: "Fundas iPhone 16 Pro", image: "FUNDAS (2).jpg" },
  { category: "Fundas", title: "Fundas iPhone 15 Pro pack", image: "FUNDAS (12).jpg" },
  { category: "Fundas", title: "Fundas iPhone 15 Pro Max", image: "FUNDAS (3).jpg" },
  { category: "Fundas", title: "Fundas iPhone 16 Pro Max", image: "FUNDAS (4).jpg" },
  { category: "AirPods", title: "AirPods Pro ANC", image: "AIRPODS.jpg" },
  { category: "Cables", title: "Cables Lightning y USB-C", image: "CABLES.jpg" },
];

const menuButton = document.querySelector(".menu-button");
const closeMenuButtons = document.querySelectorAll("[data-close-menu]");

menuButton.addEventListener("click", () => {
  const isOpen = document.body.classList.toggle("menu-open");
  menuButton.setAttribute("aria-expanded", String(isOpen));
});

closeMenuButtons.forEach((button) => {
  button.addEventListener("click", closeMenu);
});

document.addEventListener("keydown", (event) => {
  if (event.key === "Escape") {
    closeMenu();
  }
});

renderProducts();

function closeMenu() {
  document.body.classList.remove("menu-open");
  menuButton.setAttribute("aria-expanded", "false");
}

function renderProducts() {
  const grids = document.querySelectorAll(".product-grid");

  grids.forEach((grid) => {
    const category = grid.dataset.category;
    const categoryProducts = products.filter((product) => product.category === category);
    grid.innerHTML = categoryProducts.map(createProductCard).join("");
  });
}

function createProductCard(product) {
  const message = `Hola Fundas.sr, quiero consultar el precio de ${product.title}.`;
  const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;

  return `
    <article class="product-card">
      <img src="assets/${product.image}" alt="${product.title}" loading="lazy" />
      <div class="product-info">
        <div>
          <p class="product-title">${product.title}</p>
          <p class="product-meta">${product.category}</p>
        </div>
        <a class="whatsapp-button" href="${whatsappUrl}" target="_blank" rel="noreferrer">
          Consultar el precio por WhatsApp
        </a>
      </div>
    </article>
  `;
}
