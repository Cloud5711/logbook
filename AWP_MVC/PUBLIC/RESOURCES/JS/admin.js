
        function valid() {
            
            return true; 
        }
    
    
    const togglePassword = (targetInput) => {
        const inputField = document.getElementById(targetInput);
        const passwordIcon = inputField.nextElementSibling.querySelector('i');
        const isVisible = inputField.dataset.visible === "true";
        
        inputField.type = isVisible ? "password" : "text";
        passwordIcon.className = isVisible ? "fas fa-eye" : "fas fa-eye-slash";
        inputField.dataset.visible = isVisible ? "false" : "true";
    };

    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', (event) => {
            const target = event.target.dataset.target;
            togglePassword(target);

            
        });
    });
    