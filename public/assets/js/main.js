/**
 * AInsight Client Script Engine
 */

document.addEventListener('DOMContentLoaded', () => {
    // Dynamic display for criteria weight sliders (if range inputs are used)
    const sliders = document.querySelectorAll('.topsis-slider');
    sliders.forEach(slider => {
        const output = document.getElementById(slider.id + '-val');
        if (output) {
            output.textContent = getWeightLabel(slider.value);
            slider.addEventListener('input', (e) => {
                output.textContent = getWeightLabel(e.target.value);
            });
        }
    });

    // Delete item confirmation modal handler
    const deleteButtons = document.querySelectorAll('.btn-confirm-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            const confirmed = confirm('Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.');
            if (!confirmed) {
                e.preventDefault();
            }
        });
    });
});

/**
 * Returns user-friendly text descriptions for criteria score values
 * @param {number|string} val
 * @returns {string}
 */
function getWeightLabel(val) {
    const num = parseInt(val, 10);
    switch (num) {
        case 1:
            return 'Rendah (1)';
        case 2:
            return 'Cukup Rendah (2)';
        case 3:
            return 'Sedang (3)';
        case 4:
            return 'Penting (4)';
        case 5:
            return 'Sangat Penting (5)';
        default:
            return num;
    }
}
