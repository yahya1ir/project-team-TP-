

// ── Modal ──────────────────────────────────────────────
function openModal() {
    document.getElementById('modalBackdrop').classList.add('show');
    document.body.style.overflow = 'hidden';
}
function closeModalDirect() {
    document.getElementById('modalBackdrop').classList.remove('show');
    document.body.style.overflow = '';
}
function closeModal(e) {
    if (e.target === document.getElementById('modalBackdrop')) closeModalDirect();
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModalDirect(); });




// ── Grid / List toggle (persisted) ────────────────────
function switchView(v) {
    const grid = document.getElementById('view-grid');
    const list = document.getElementById('view-list');
    const btnG = document.getElementById('btn-grid');
    const btnL = document.getElementById('btn-list');
    if (v === 'grid') {
        grid.style.display = ''; list.style.display = 'none';
        btnG.classList.add('active'); btnL.classList.remove('active');
    } else {
        grid.style.display = 'none'; list.style.display = '';
        btnL.classList.add('active'); btnG.classList.remove('active');
    }
    localStorage.setItem('formations_view', v);
}
const savedView = localStorage.getItem('formations_view');
if (savedView) switchView(savedView);
