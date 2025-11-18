import Swal from "sweetalert2";
import toast from "bootstrap/js/src/toast.js";

document.addEventListener("DOMContentLoaded", function() {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    //Funcion para cambiar el estado del usuario
    async function cambiarEstado(materialId, nuevoEstado, button) {
        try {
            //Sweetalert para confirmar una inactivacion
            const result = await Swal.fire({
                title: 'Cambiar estado',
                text: `¿Estás seguro de que deseas cambiar el estado a ${nuevoEstado}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, cambiar estado',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            });

            if(!result.isConfirmed) {
                await Swal.fire({
                    title: 'Cambiar estado',
                    text: 'Operación cancelada.',
                    icon: 'info',
                    confirmButtonText: 'Aceptar',
                });
                return;
            }

            const response = await fetch(`/admin/materiales/${materialId}/inhabilitar`, {
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

                //Eliminar la fila
                const fila = button.closest('tr');
                if (fila) {
                    fila.remove();
                }

                await Swal.fire({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    showCancelButton: true,
                    cancelButtonText: 'Cerrar',
                    background: '#1d784d',
                    theme: 'dark',
                    title: 'Cambiar estado',
                    icon: 'success',
                    html: `<i class="bi bi-check-circle-fill"></i> El estado del material ha sido cambiado exitosamente.`,
                });

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
        document.querySelectorAll('.toggleEstadoBtn').forEach(button => {
            button.addEventListener('click', function () {
                const materialId = this.dataset.materialId;
                const nuevoEstado = this.dataset.estado;
                cambiarEstado(materialId, nuevoEstado, this)
            });
        });
    }

    inicializarBotones();
});
