function validateForm() {
    console.log("Validación iniciada");
    var nombre = document.getElementsByName("nombre")[0].value;
    var apellido = document.getElementsByName("apellido")[0].value;
    var telefono = document.getElementsByName("telefono")[0].value;
    var edad = document.getElementsByName("edad")[0].value;

    // Validación de nombre: solo letras y espacios
    var nombreRegex = /^[a-zA-Z\s]+$/;
    if (nombre == "") {
        alert("El nombre debe estar lleno");
        console.log("Nombre vacío");
        return false;
    } else if (!nombreRegex.test(nombre)) {
        alert("El nombre solo debe contener letras y espacios");
        console.log("Nombre inválido");
        return false;
    }

    // Validación de apellido: solo letras y espacios
    var apellidoRegex = /^[a-zA-Z\s]+$/;
    if (apellido == "") {
        alert("El apellido debe estar lleno");
        console.log("Apellido vacío");
        return false;
    } else if (!apellidoRegex.test(apellido)) {
        alert("El apellido solo debe contener letras y espacios");
        console.log("Apellido inválido");
        return false;
    }

    // Validación de teléfono: solo números, guiones y espacios
    var telefonoRegex = /^[\d\-\s]+$/;
    if (telefono == "") {
        alert("El teléfono debe estar lleno");
        console.log("Teléfono vacío");
        return false;
    } else if (!telefonoRegex.test(telefono)) {
        alert("El teléfono solo debe contener números, guiones y espacios");
        console.log("Teléfono inválido");
        return false;
    }

    // Validación de edad: solo números
    if (edad == "") {
        alert("La edad debe estar llena");
        console.log("Edad vacía");
        return false;
    } else if (isNaN(edad) || edad < 1 || edad > 150) {
        alert("La edad debe ser un número entre 0 y 150");
        console.log("Edad inválida");
        return false;
    }

    console.log("Validación pasada");
    return true;
}