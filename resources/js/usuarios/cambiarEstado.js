document.addEventListener("DOMContentLoaded", function() {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    //Funcion para cambiar el estado del usuario
    async function cambiarEstado(userId, nuevoEstado, button) {
        try {
            const response = await fetch(`/admin/users/${userId}/desactivar`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({ estado: nuevoEstado })
            });

            if (response.ok) {
                button.textContent = nuevoEstado.charAt(0).toUpperCase() + nuevoEstado.slice(1);
                button.dataset.estado = nuevoEstado === 'activo' ? 'inactivo' : 'activo';
                button.classList.toggle('btn-success');
                button.classList.toggle('btn-danger');

                // Cambiar opacidad de la fila completa
                const fila = button.closest('tr');
                if (fila) {
                    if (nuevoEstado === 'inactivo') {
                        fila.classList.add('opacity-50');
                    } else {
                        fila.classList.remove('opacity-50');
                    }
                }
            } else {
                alert('Error al cambiar el estado del usuario.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al cambiar el estado del usuario.');
        }
    }

    //Funcion inicializar botones de cambiar estado
    function inicializarBotones() {
        document.querySelectorAll('.btn-cambiar-estado').forEach(button => {
            button.addEventListener('click', function () {
                const userId = this.dataset.userId;
                const nuevoEstado = this.dataset.estado;
                cambiarEstado(userId, nuevoEstado, this)
            });
        });
    }

    inicializarBotones();
});
