function validarLogin() {
    var tipoId = document.getElementById('tipo_id').value;
    var numId = document.getElementById('num_id').value;
    var fechaNac = document.getElementById('fecha_nac').value;

    if (tipoId === '' || numId === '' || fechaNac === '') {
        alert('Por favor, complete todos los campos.');
        return false;
    }

    // Validar formato de fecha YYYY-MM-DD
    var fechaRegex = /^\d{4}-\d{2}-\d{2}$/;
    if (!fechaRegex.test(fechaNac)) {
        alert('Por favor, ingrese la fecha en el formato correcto (YYYY-MM-DD).');
        return false;
    }

    return true;
}

// Agregar esta función para formatear la entrada de fecha
document.addEventListener('DOMContentLoaded', function() {
    var fechaNacInput = document.getElementById('fecha_nac');
   
    fechaNacInput.addEventListener('input', function(e) {
        var input = e.target.value.replace(/\D/g, '').substring(0, 8);
        var formatted = '';
       
        if (input.length > 4) {
            formatted += input.substring(0, 4) + '-';
            if (input.length > 6) {
                formatted += input.substring(4, 6) + '-' + input.substring(6);
            } else {
                formatted += input.substring(4);
            }
        } else {
            formatted = input;
        }
       
        e.target.value = formatted;
    });
});