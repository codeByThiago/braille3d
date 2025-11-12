

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

const editIcon = document.querySelector('.profile-edit-icon');
const fotoInput = document.getElementById('foto-perfil-input');
const formFoto = document.getElementById('form-foto');

// Ao clicar no ícone, abre o input file
editIcon.addEventListener('click', () => {
    fotoInput.click();
});

// Ao selecionar o arquivo, envia o form automaticamente
fotoInput.addEventListener('change', () => {
    if(fotoInput.files.length > 0) {
        const formData = new FormData();
        formData.append('foto_perfil', fotoInput.files[0]);

        fetch('/perfil', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Atualiza a imagem no perfil sem recarregar a página
                document.querySelector('.profile-avatar').src = data.filePath + '?t=' + new Date().getTime();
                document.querySelector('.profile-picture').src = data.filePath + '?t=' + new Date().getTime();
                // alert(data.message);
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Ocorreu um erro ao atualizar a foto!');
        });
    }
});