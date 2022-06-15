function alert(message, type) {
    M.toast({ html: message, classes: `rounded ${type}` });
}

function proceso_fetch(url, data) {
    return fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded', Authentication: 'secret' },
        body: data
    }).then(response => {
        if (!response.ok) throw Error(response.status);
        return response.json();
    }).catch(error => alert('<span class="red-text">Error en la consulta</span>', 'red lighten-5'));
}

function base_url(array) {
    return `http://localhost:8081/${array.join('/')}`;
}