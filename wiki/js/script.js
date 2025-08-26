document.addEventListener('DOMContentLoaded', function() {
    // Lógica para a validação do formulário de registro
    const registroForm = document.querySelector('form[action="registro.php"]');

    if (registroForm) {
        // Cria um novo campo para confirmação de senha
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.createElement('input');
        
        confirmPasswordInput.setAttribute('type', 'password');
        confirmPasswordInput.setAttribute('id', 'confirm_password');
        confirmPasswordInput.setAttribute('name', 'confirm_password');
        confirmPasswordInput.setAttribute('required', 'true');

        // Adiciona o novo campo ao formulário
        const passwordLabel = document.querySelector('label[for="password"]');
        const confirmPasswordLabel = document.createElement('label');
        confirmPasswordLabel.setAttribute('for', 'confirm_password');
        confirmPasswordLabel.textContent = 'Confirme a Senha:';

        passwordLabel.parentNode.insertBefore(confirmPasswordLabel, passwordLabel.nextSibling);
        confirmPasswordLabel.parentNode.insertBefore(confirmPasswordInput, confirmPasswordLabel.nextSibling);

        // Adiciona um evento para a validação
        registroForm.addEventListener('submit', function(event) {
            if (passwordInput.value !== confirmPasswordInput.value) {
                alert('As senhas não correspondem. Por favor, tente novamente.');
                event.preventDefault(); // Impede o envio do formulário
                return false;
            }
        });
    }

    // Você pode adicionar outras funcionalidades aqui, como:
    // - Confirmação para exclusão de páginas
    // - Requisições AJAX para validação em tempo real de nomes de usuário
});