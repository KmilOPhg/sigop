import { sigopConfirm, sigopToastError, sigopToastSuccess } from "./lib/swalTheme.js";

//Single Page Application
//Aplicación de una sola página
document.addEventListener("DOMContentLoaded", () => {

    const pageEl = document.querySelector('.page');
    if (!pageEl) return;

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    //Agarrar la seccion en la que se está
    const seccion = pageEl.dataset.seccion;
    console.log('Sección detectada', seccion);

    // Detectar automáticamente cuál contenedor existe
    function getTableContainer() {
        return document.querySelector("#contenedor_tabla_materiales, #contenedor_tabla_bodega");
    }

    async function cambiarEstado(id, nuevoEstado, seccion, button) {
        try {
            const confirm = await sigopConfirm({
                title: "Cambiar estado",
                text: `¿Deseas cambiar el estado a ${nuevoEstado}?`,
                icon: "warning",
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
                await sigopToastError("No se pudo cambiar el estado. Intenta de nuevo.");
                return;
            }

            button.closest("tr")?.remove();

            await sigopToastSuccess(`Estado actualizado a «${nuevoEstado}».`);

        } catch (e) {
            console.error(e);
            await sigopToastError("No se pudo cambiar el estado. Intenta de nuevo.");
        }
    }


    document.addEventListener("click", (e) => {

        // --------------------
        // AJAX LOAD / PAGINACIÓN
        // --------------------
        const link = e.target.closest("a.ajax-load, a.sigop-ajax-page");
        if (link) {
            e.preventDefault();

            fetch(link.href, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
                .then((r) => {
                    if (!r.ok) {
                        throw new Error("Respuesta no OK");
                    }
                    return r.text();
                })
                .then((html) => {
                    // Paginación: solo recarga tabla + modales de la página actual
                    if (link.classList.contains("sigop-ajax-page")) {
                        const container = getTableContainer();

                        if (container) {
                            container.innerHTML = html;
                            if (window.Alpine?.initTree) {
                                window.Alpine.initTree(container);
                            }
                            container.scrollIntoView({ behavior: "smooth", block: "nearest" });
                        }
                    }

                    // ajax-load = recarga la seccion de la pagina
                    if (link.classList.contains("ajax-load")) {
                        const pageContainer = document.querySelector(".page");
                        const cardContainer = document.querySelector(".card");

                        if (pageContainer) {
                            pageContainer.innerHTML = html;
                            if (window.Alpine?.initTree) {
                                window.Alpine.initTree(pageContainer);
                            }
                        } else if (cardContainer) {
                            cardContainer.innerHTML = html;
                            if (window.Alpine?.initTree) {
                                window.Alpine.initTree(cardContainer);
                            }
                        }
                    }
                })
                .catch(async () => {
                    await sigopToastError("No se pudo cargar el contenido.");
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
