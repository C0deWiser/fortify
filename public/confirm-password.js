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

    function showError(message) {
        var target = document.querySelector('input[name="password"]');
        if (target) {
            var invalid = target.closest('div').querySelector('.invalid');
            if (invalid) {
                invalid.textContent = message;
            }
        }
    }

    fetch(el.dataset.optionsUrl, {
        method: 'GET',
        headers: { 'Accept': 'application/json' },
        credentials: 'same-origin',
    })
        .then(function (response) {
            if (!response.ok) {
                console.error('passkey confirm: failed to fetch options, status', response.status);
                throw new Error('Unable to fetch passkey confirmation options.');
            }

            console.log('passkey confirm: options fetched successfully');
            return response.json();
        })
        .then(function (response) {
            console.log('passkey confirm: calling navigator.credentials.get');

            return navigator.credentials.get({
                publicKey: FortifyPasskeys.toPublicKeyCredentialRequestOptions(response.options),
            });
        })
        .then(function (credential) {
            if (!credential) {
                console.log('passkey confirm: no credential received (user cancelled?)');
                return;
            }

            console.log('passkey confirm: credential received, posting to', el.dataset.confirmUrl);

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
            if (!response) {
                return;
            }

            if (!response.ok) {
                return response.json().catch(function () {
                    return null;
                }).then(function (body) {
                    var message = (body && body.message) || 'Unable to confirm with passkey.';
                    console.error('passkey confirm: confirm failed -', message, body);
                    showError(message);
                    throw new Error(message);
                });
            }

            console.log('passkey confirm: confirmation successful');
            return response.json();
        })
        .then(function (body) {
            if (body) {
                console.log('passkey confirm: redirecting to', body.redirect);
                window.location.href = body.redirect || window.location.href;
            }
        })
        .catch(function (error) {
            console.error('passkey confirm: error -', error);

            if (error && error.name === 'NotAllowedError') {
                return;
            }

            var message = error && error.message ? error.message : 'Passkey confirmation failed.';
            showError(message);
        });
})();
