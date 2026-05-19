const inputPersona = document.getElementById('persona_nombre');
const resultados = document.getElementById('resultadosPersonas');
const personaId = document.getElementById('persona_id');

const selectRol = document.getElementById('idRol');
const contenedorPersona = document.getElementById('contenedorPersona');


// mostrar u ocultar búsqueda de persona segun rol seleccionado

selectRol.addEventListener('change', function () {

    const textoRol =
        this.options[this.selectedIndex].text;

    if(selectRol.value == 3) // si es odontologo
    {
        contenedorPersona.classList.remove('d-none');
    }
    else
    {
        contenedorPersona.classList.add('d-none');

        // limpiar campos
        inputPersona.value = '';
        personaId.value = '';
        resultados.innerHTML = '';
    }

});


// buscar personas
inputPersona.addEventListener('keyup', async function () {

    let texto = this.value;

    if(texto.length < 2)
    {
        resultados.innerHTML = '';
        return;
    }

    const response = await fetch(
        `/buscar-personas?texto=${texto}`
    );

    const personas = await response.json();

    resultados.innerHTML = '';

    personas.forEach(persona => {

        resultados.innerHTML += `
            <button type="button"
                class="list-group-item list-group-item-action"
                onclick="seleccionarPersona(
                    ${persona.idPersona},
                    '${persona.persona.nombre} ${persona.persona.apellido}'
                )">

                ${persona.persona.nombre} ${persona.persona.apellido}

            </button>
        `;
    });

});


// seleccionar persona

function seleccionarPersona(id, nombre)
{
    inputPersona.value = nombre;

    personaId.value = id;

    resultados.innerHTML = '';
}