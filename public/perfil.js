

document.addEventListener("DOMContentLoaded", function() {
  const overlay = document.getElementById("overlay-edicao");
  const btnEditarPerfil = document.querySelector(".edit-profile-btn");
  const btnEditarDados = document.querySelector(".action-btn-primary");
  const btnCancelar = document.getElementById("cancelar-edicao");

  // Mostrar formulário ao clicar em “Editar Perfil” ou “Editar Dados”
  [btnEditarPerfil, btnEditarDados].forEach(btn => {
    btn.addEventListener("click", () => {
      overlay.classList.remove("hidden");
      setTimeout(() => overlay.classList.add("show"), 10);
    });
  });

  // Fechar ao clicar em “Cancelar” ou fora do formulário
  btnCancelar.addEventListener("click", fecharFormulario);
  overlay.addEventListener("click", e => {
    if (e.target === overlay) fecharFormulario();
  });

  function fecharFormulario() {
    overlay.classList.remove("show");
    setTimeout(() => overlay.classList.add("hidden"), 400);
  }
});