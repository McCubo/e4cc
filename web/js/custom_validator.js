function validateRequired(value) {
    return (value !== null && value.trim() !== '');
}

function validateEmail(value) {
    var emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
    return emailRegex.test(value);
}

function validateDUI(value) {
    var regex = /^\d{8}-\d$/;
    return regex.test(value);
}