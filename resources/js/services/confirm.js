import Swal from 'sweetalert2';
import API from './api';

export function confirmDelete(model, id) {
    Swal.fire({
        title: 'Deseja excluir este registro?',
        text: 'Esta operação é irreversível!',
        icon: 'warning',
        showCloseButton: true,
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Confirmar',
        reverseButtons: true,
        focusConfirm: false,
    }).then(result => {
        if (result.value) {
            new API(`/api/v1/${model}`).delete(id).then(() => {
                document.querySelector('.dt-buttons .fa-refresh').click();
            });
        }
    });
}
