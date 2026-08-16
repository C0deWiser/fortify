(function () {
    'use strict';

    var form = document.getElementById('passkeyRegister');
    var unsupported = document.getElementById('passkeyUnsupported');

    if (!form || !unsupported || !window.FortifyPasskeys) {
        return;
    }

    if (!FortifyPasskeys.isSupported()) {
        unsupported.textContent = FortifyPasskeys.describeUnsupported();
        unsupported.style.display = 'block';
        return;
    }

    form.style.display = 'block';

    function csrfHeaders() {
        var headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        };

        var csrf = FortifyPasskeys.csrfHeader(form);

        for (var header in csrf) {
            if (csrf.hasOwnProperty(header)) {
                headers[header] = csrf[header];
            }
        }

        return headers;
    }

    function showEnvironmentError(message) {
        unsupported.textContent = message;
        unsupported.style.display = 'block';
    }

    function clearEnvironmentError() {
        unsupported.textContent = '';
        unsupported.style.display = 'none';
    }

    function showInvalid(message) {
        var el = form.querySelector('.invalid');

        if (!el) {
            return;
        }

        el.textContent = message;
        el.hidden = false;
    }

    function renderResponseErrors(body, status) {
        if (body && body.errors) {
            var messages = [];

            for (var field in body.errors) {
                if (body.errors.hasOwnProperty(field)) {
                    messages = messages.concat(body.errors[field]);
                }
            }

            if (messages.length) {
                showInvalid(messages.join('\n'));
                return;
            }
        }

        showInvalid((body && body.message) || 'Request failed with status ' + status + '.');
    }

    function clearErrors() {
        clearEnvironmentError();

        form.querySelectorAll('.invalid').forEach(function (el) {
            el.textContent = '';
            el.hidden = true;
        });
    }

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        clearErrors();

        var submit = form.querySelector('button[type="submit"]');
        var name = form.querySelector('input[name="name"]');

        if (submit) {
            submit.disabled = true;
        }

        fetch(form.action, {
            method: 'GET',
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin',
        })
            .then(function (response) {
                if (!response.ok) {
                    renderResponseErrors(null, response.status);
                    return null;
                }

                return response.json();
            })
            .then(function (response) {
                if (!response) {
                    return null;
                }

                return navigator.credentials.create({
                    publicKey: FortifyPasskeys.toPublicKeyCredentialCreationOptions(response.options),
                });
            })
            .then(function (credential) {
                if (!credential) {
                    return null;
                }

                return fetch(form.dataset.storeUrl, {
                    method: 'POST',
                    headers: csrfHeaders(),
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        name: name ? name.value : '',
                        credential: FortifyPasskeys.serializeCredential(credential),
                    }),
                });
            })
            .then(function (response) {
                if (!response) {
                    return null;
                }

                if (!response.ok) {
                    return response.json().catch(function () { return null; }).then(function (body) {
                        renderResponseErrors(body, response.status);
                        return null;
                    });
                }

                window.location.reload();
            })
            .catch(function (reason) {
                if (reason instanceof DOMException && reason.name === 'InvalidStateError') {
                    showInvalid('A passkey for this device is already registered.');
                    return;
                }

                var message = FortifyPasskeys.describeError(reason);

                if (message) {
                    showEnvironmentError(message);
                }
            })
            .finally(function () {
                if (submit) {
                    submit.disabled = false;
                }
            });
    });
})();
