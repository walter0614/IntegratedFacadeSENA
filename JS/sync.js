function sync(element, type) {
    element.disabled = true
    element.innerHTML = 'Sincronizando... '
        + '<img src="../Assets/loading.gif" class="w-1" alt="Cargando...">'
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
            element.disabled = false
            element.innerHTML = 'Sincronizar'
            console.log('Success:', response)
        })
}
