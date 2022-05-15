function alert(message, type) {
    M.toast({ html: message, classes: `rounded ${type}` });
}