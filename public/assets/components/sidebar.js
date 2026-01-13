const sideItems = document.querySelectorAll('.side-item');

function clearActiveClass() {
  sideItems.forEach(item => item.classList.remove('active'));
}

function restoreActiveItem() {
  const activeItem = localStorage.getItem('activeItem');
  clearActiveClass(); // Remove a classe 'active' de todos os itens
  if (activeItem) {
    const item = document.querySelector(`.side-item[data-item="${activeItem}"]`);
    if (item) {
      item.classList.add('active');
    }
  }
}

// Adiciona o evento de clique para cada item
sideItems.forEach(item => {
  item.addEventListener('click', function () {
    // Remove a classe 'active' de todos os itens
    clearActiveClass();
    // Adiciona a classe 'active' ao item clicado
    this.classList.add('active');
    // Salva o item ativo no localStorage
    const itemName = this.getAttribute('data-item');
    localStorage.setItem('activeItem', itemName);
  });
});

const financeiroToggle = document.getElementById('financeiro-toggle');
const submenuFinanceiro = document.querySelector('.submenu-financeiro');

if (financeiroToggle && submenuFinanceiro) {
    financeiroToggle.addEventListener('click', function(e) {
        e.preventDefault();
        submenuFinanceiro.style.display = submenuFinanceiro.style.display === 'none' ? 'block' : 'none';
    });

    // Obriga escolher uma opção do submenu antes de sair
    submenuFinanceiro.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function() {
            submenuFinanceiro.style.display = 'none';
        });
    });
}
restoreActiveItem();