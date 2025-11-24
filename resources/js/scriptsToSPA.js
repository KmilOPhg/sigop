import Swal from "sweetalert2";

//Single Page Application
//Aplicación de una sola página
document.addEventListener("DOMContentLoaded", () => {

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    //Agarrar la seccion en la que se está
    const seccion = document.querySelector('.page').dataset.seccion;
    console.log('Sección detectada', seccion);

    // Detectar automáticamente cuál contenedor existe
    function getTableContainer() {
        return document.querySelector("#contenedor_tabla_materiales, #contenedor_tabla_bodega");
    }

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
            console.log('Ruta: ', res.url);

            if (!res.ok) {
                alert("Error al cambiar estado.");
                return;
            }

            button.closest("tr")?.remove();

            await Swal.fire({
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
                        document.querySelector(".card").innerHTML = html;
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
                seccion,
                toggleBtn
            ).then();
        }

    });
});
