function sync(element, type, route) {
    element.disabled = true
    element.innerHTML = 'Sincronizando... '
        + '<img src="../Assets/loading.gif" class="w-1" alt="Cargando...">'
    $('.d-msg').remove()
    let url = '../POST/SyncPOST.php'
    let data = { type: type }

    fetch(url, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'
        }
    }).then(res => res.json())
        .catch(error => console.error('Error:', error))
        .then(function (response) {

            if (!route) {
                element.disabled = false
                element.innerHTML = 'Sincronizar'
            }

            if (Array.isArray(response.errors) && response.errors.length) {
                errors(response.errors)
            } else {
                showMsg(response.status, response.msg)
            }

            if (response.status && !route) {
                setTimeout(function () { location.reload(); }, 2000)
            } else if (route) {
                setTimeout(function () {
                    window.location.href = route
                }, 2000)
            }
        })
}

function errors(errors) {
    let html = '<div class="d-msg"><b>Estos registros no fueron sincronizados, intente nuevamente.</b>'
        + '<table class="table table-borderless table-responsive">'
        + '<tr><td>Id</td><td>Nombre</td><td>Error</td></tr>'

    errors.forEach(function (value, index) {
        html += `<tr class="alert alert-danger">`
            + `<td>${value.id}</td><td>${value.name}</td><td>${value.error}</td></tr>`
    })
    html += '</table></div>'

    $('#btn-sync').parent().append(html)
}

function showMsg(status, msg) {
    let color = 'success'

    if (!status) {
        color = 'warning'
    }

    let html = `<div class="d-msg mt-3"><span class="alert alert-${color}">${msg}</span></div>`
    $('#btn-sync').parent().append(html)
}