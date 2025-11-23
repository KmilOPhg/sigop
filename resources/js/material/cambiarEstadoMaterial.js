import Swal from "sweetalert2";
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
                    icon: 'success',
                    title: `Estado actualizado: ${nuevoEstado}`,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 2200,
                    timerProgressBar: true,

                    // Fondo verde suave translúcido con brillo sutil
                    background: 'rgba(13, 110, 253, 0.75)',   // azul del sistema, translúcido
                    color: '#f8f9fa',                         // texto claro
                    iconColor: 'rgba(14,0,255,0.75)',                     // verde pastel (match con "Activo")

                    customClass: {
                        popup: `shadow-lg
                            backdrop-blur-md
                            rounded-xl
                            border border-emerald-300/40`,
                        title: `font-semibold tracking-wide`
                    }
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
    document.addEventListener('click', function(e) {

        // PAGINACIÓN O AJAX LOAD
        const link = e.target.closest('a.page-link, a.ajax-load');
        if (link) {
            e.preventDefault();

            fetch(link.href, {
                headers: { "X-Requested-With": "XMLHttpRequest" }
            })
                .then(r => r.text())
                .then(html => {
                    if (link.classList.contains('page-link')) {
                        document.querySelector('#contenedor_tabla').innerHTML = html;
                    }

                    if (link.classList.contains('ajax-load')) {
                        document.querySelector('#all-table').innerHTML = html;
                    }
                })
                .catch(console.error);

            return;
        }

        // ---------------------------
        // BOTÓN CAMBIAR ESTADO
        // ---------------------------
        const toggleBtn = e.target.closest('.toggleEstadoBtn');
        if (toggleBtn) {
            const materialId = toggleBtn.dataset.materialId;
            const nuevoEstado = toggleBtn.dataset.estado;
            cambiarEstado(materialId, nuevoEstado, toggleBtn).then(r => {r});
        }

    });
});
