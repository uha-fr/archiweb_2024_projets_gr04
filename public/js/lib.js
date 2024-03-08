/** Soumet le formulaire de classe role-form le plus proche de selectElement 
 * 
 * @param {*} selectElement <select></select>
 */
function submitForm(selectElement) {
    var form = selectElement.closest('.role-form');
    form.submit();
}