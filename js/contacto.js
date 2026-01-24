function cerrarModal() {
    document.getElementById('modalExito').style.display = 'none';
    // Limpiar URL
    const url = window.location.href.split('?')[0];
    window.history.replaceState({}, document.title, url);
}

// Cerrar modal al hacer click fuera
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modalExito');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                cerrarModal();
            }
        });
    }
    
    // Mostrar nombres de archivos seleccionados
    const fileInput = document.querySelector('input[type="file"]');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const files = this.files;
            const fileList = document.getElementById('file-list');
            
            if (files.length > 0) {
                let nombres = [];
                for (let i = 0; i < files.length; i++) {
                    nombres.push(files[i].name);
                }
                fileList.textContent = nombres.join(', ');
            } else {
                fileList.textContent = '';
            }
        });
    }
});