import './bootstrap';
import Swal from 'sweetalert2';

// Make SweetAlert2 globally available
window.Swal = Swal;

// Custom SweetAlert2 configurations for ToDoinAja
window.TodoAlert = {
    success: (title, text = '') => {
        return Swal.fire({
            icon: 'success',
            title: title,
            text: text,
            confirmButtonColor: '#0d6efd',
            showConfirmButton: true,
            timer: 3000,
            timerProgressBar: true
        });
    },
    
    error: (title, text = '') => {
        return Swal.fire({
            icon: 'error',
            title: title,
            text: text,
            confirmButtonColor: '#dc3545',
            showConfirmButton: true
        });
    },
    
    warning: (title, text = '') => {
        return Swal.fire({
            icon: 'warning',
            title: title,
            text: text,
            confirmButtonColor: '#ffc107',
            confirmButtonTextColor: '#000',
            showConfirmButton: true
        });
    },
    
    info: (title, text = '') => {
        return Swal.fire({
            icon: 'info',
            title: title,
            text: text,
            confirmButtonColor: '#0dcaf0',
            showConfirmButton: true
        });
    },
    
    confirm: (title, text = '', confirmText = 'Yes, confirm!', cancelText = 'Cancel') => {
        return Swal.fire({
            icon: 'question',
            title: title,
            text: text,
            showCancelButton: true,
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#6c757d',
            confirmButtonText: confirmText,
            cancelButtonText: cancelText
        });
    },
    
    delete: (title = 'Are you sure?', text = 'You won\'t be able to revert this!') => {
        return Swal.fire({
            icon: 'warning',
            title: title,
            text: text,
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        });
    },
    
    loading: (title = 'Processing...', text = 'Please wait') => {
        return Swal.fire({
            title: title,
            text: text,
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }
};
