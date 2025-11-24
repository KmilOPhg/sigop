import Swal from "sweetalert2";

document.addEventListener("DOMContentLoaded", () => {

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Detectar automáticamente cuál contenedor existe
    function getTableContainer() {
        return document.querySelector("#contenedor_tabla, #contenedor_tabla_bodega");
    }
    //const apiBase = tableContainer.dataset.api; // "bodegas" o "materiales"

    async function cambiarEstado(id, nuevoEstado, seccion, button) {
        try {
            const confirm = await Swal.fire({
                title: "Cambiar estado",
                text: `¿Deseas cambiar el estado a ${nuevoEstado}?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, cambiar",
                cancelButtonText: "Cancelar",
            });

            if (!confirm.isConfirmed) return;

            const res = await fetch(`/admin/${seccion}/${id}/inhabilitar`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token
                },
                body: JSON.stringify({ estado: nuevoEstado })
            });

            if (!res.ok) {
                alert("Error al cambiar estado.");
                return;
            }

            button.closest("tr")?.remove();

            Swal.fire({
                icon: "success",
                title: `Estado cambiado a ${nuevoEstado}`,
                toast: true,
                position: "bottom-end",
                timer: 2000,
                showConfirmButton: false,
            });

        } catch (e) {
            console.error(e);
            alert("Error al cambiar estado.");
        }
    }


    document.addEventListener("click", (e) => {

        // --------------------
        // AJAX LOAD / PAGINACIÓN
        // --------------------
        const link = e.target.closest("a.ajax-load, a.page-link");
        if (link) {
            e.preventDefault();

            fetch(link.href, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
                .then(r => r.text())
                .then(html => {
                    // page-link = solo recarga la tabla
                    if (link.classList.contains("page-link")) {
                        const container = getTableContainer();

                        if(container) container.innerHTML = html;
                    }

                    // ajax-load = recarga toda la card (vista completa)
                    if (link.classList.contains("ajax-load")) {
                        document.querySelector(".card").outerHTML = html;
                    }
                });

            return;
        }

        // --------------------
        // BOTÓN DE CAMBIAR ESTADO
        // --------------------
        const toggleBtn = e.target.closest(".toggleEstadoBtn");
        if (toggleBtn) {
            cambiarEstado(
                toggleBtn.dataset.id,
                toggleBtn.dataset.estado,
                toggleBtn.dataset.seccion,
                toggleBtn
            );
        }

    });
});
