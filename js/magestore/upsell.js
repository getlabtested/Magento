function toggleUpsellCartElement(el) {

    if (el != 'complete-checkup-lab') {
        document.getElementById('complete-checkup-lab').checked = false;
    }

    if (el == 'complete-checkup-lab') {

        document.getElementById('diabetes-lab').checked = false;
        document.getElementById('lipid-lab').checked = false;
        document.getElementById('liver-lab').checked = false;
        document.getElementById('thyroid-lab').checked = false;

    }
}