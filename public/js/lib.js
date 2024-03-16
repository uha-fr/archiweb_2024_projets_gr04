/** Soumet le formulaire de classe role-form le plus proche de selectElement 
 * 
 * @param {*} selectElement <select></select>
 */
function submitForm(selectElement) {
    var form = selectElement.closest('.role-form');
    form.submit();
}

function addFavoris(element, idItem, type) {
    event.stopPropagation();
    console.log("id=",idItem," type=",type);

    var myJson = {
        idFavori: idItem,
        type: type,
    };

    $.ajax({
        type: 'POST',
        url: '/Ajax/addFavori',
        data: JSON.stringify(myJson),
        contentType: 'application/json',
        success: function(response) {
            if(response == 200) {
                console.log("Succes add fav");
                console.log(element);
            }
        },
        error: function(xhr, status, error) {
            console.error('Erreur lors de la requête :', error);
        }
    });
}