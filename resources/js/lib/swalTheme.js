import Swal from "sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

const customClass = {
    popup: "sigop-swal-popup",
    title: "sigop-swal-title",
    htmlContainer: "sigop-swal-html",
    confirmButton: "sigop-swal-confirm",
    cancelButton: "sigop-swal-cancel",
    denyButton: "sigop-swal-cancel",
    actions: "sigop-swal-actions",
};

/** Modales estándar (confirmación, contenido HTML, etc.) */
export const sigopSwal = Swal.mixin({
    customClass,
    buttonsStyling: false,
});

/**
 * Diálogo de confirmación con textos por defecto en español.
 * Las opciones del caller tienen prioridad.
 */
export function sigopConfirm(options = {}) {
    return sigopSwal.fire({
        showCancelButton: true,
        confirmButtonText: "Sí, continuar",
        cancelButtonText: "Cancelar",
        ...options,
    });
}

/**
 * Toast inferior derecho, alineado al diseño SIGOP.
 */
export function sigopToast(icon, title, options = {}) {
    return Swal.fire({
        toast: true,
        position: "bottom-end",
        icon,
        title,
        showConfirmButton: false,
        timer: icon === "error" ? 3800 : 2400,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
        customClass: {
            popup: "sigop-swal-toast",
        },
        ...options,
    });
}

export const sigopToastSuccess = (title, options = {}) =>
    sigopToast("success", title, options);

export const sigopToastError = (title, options = {}) =>
    sigopToast("error", title, options);
