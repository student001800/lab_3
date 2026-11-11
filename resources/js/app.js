import * as bootstrap from 'bootstrap';
import $ from 'jquery';

window.$ = window.jQuery = $;
window.bootstrap = bootstrap;

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-bs-toggle="popover"]').forEach((element) => {
        new bootstrap.Popover(element, { trigger: 'hover focus', placement: 'top' });
    });

    const loadButton = document.getElementById('loadBtn');
    const toastElement = document.getElementById('loadToast');
    if (loadButton && toastElement) {
        loadButton.addEventListener('click', () => {
            bootstrap.Toast.getOrCreateInstance(toastElement, { delay: 3000 }).show();
        });
    }

    const modals = Array.from(document.querySelectorAll('.modal'));
    let activeModalIndex = -1;
    let switchingModal = false;
    modals.forEach((modal, index) => {
        modal.addEventListener('shown.bs.modal', () => { activeModalIndex = index; });
        modal.addEventListener('hidden.bs.modal', () => {
            if (activeModalIndex === index) activeModalIndex = -1;
        });
    });

    document.addEventListener('keydown', (event) => {
        if (switchingModal || activeModalIndex < 0 || !['ArrowLeft', 'ArrowRight'].includes(event.key)) return;
        if (event.target.matches('input, textarea, select, [contenteditable="true"]')) return;
        event.preventDefault();

        const direction = event.key === 'ArrowRight' ? 1 : -1;
        const nextIndex = (activeModalIndex + direction + modals.length) % modals.length;
        const currentIndex = activeModalIndex;
        const current = bootstrap.Modal.getOrCreateInstance(modals[currentIndex]);

        switchingModal = true;
        modals[currentIndex].addEventListener('hidden.bs.modal', () => {
            switchingModal = false;
            bootstrap.Modal.getOrCreateInstance(modals[nextIndex]).show();
        }, { once: true });
        current.hide();
    });
});
