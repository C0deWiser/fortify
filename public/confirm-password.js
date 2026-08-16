(function () {
    'use strict';

    var el = document.getElementById('passkeyConfirm');

    if (!el || !window.FortifyPasskeys || !FortifyPasskeys.isSupported()) {
        return;
    }

    function csrfHeaders() {
        var headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        };

        var csrf = FortifyPasskeys.csrfHeader(null);

        for (var header in csrf) {
            if (csrf.hasOwnProperty(header)) {
                headers[header] = csrf[header];
            }
        }

        return headers;
    }

    fetch(el.dataset.optionsUrl, {
        method: 'GET',
        headers: { 'Accept': 'application/json' },
        credentials: 'same-origin',
    })
        .then(function (response) {
            if (!response.ok) {
                throw new Error('Unable to fetch passkey confirmation options.');
            }

            return response.json();
        })
        .then(function (response) {
            return navigator.credentials.get({
                publicKey: FortifyPasskeys.toPublicKeyCredentialRequestOptions(response.options),
            });
        })
        .then(function (credential) {
            return fetch(el.dataset.confirmUrl, {
                method: 'POST',
                headers: csrfHeaders(),
                credentials: 'same-origin',
                body: JSON.stringify({
                    credential: FortifyPasskeys.serializeCredential(credential),
                }),
            });
        })
        .then(function (response) {
            if (!response.ok) {
                throw new Error('Unable to confirm with passkey.');
            }

            return response.json();
        })
        .then(function (body) {
            window.location.href = body && body.redirect ? body.redirect : window.location.href;
        })
        .catch(function () {
            // Passkey confirmation failed or was cancelled; fall back to the password form.
        });
})();
