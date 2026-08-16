(function () {
    'use strict';

    var el = document.getElementById('passkeyLogin');

    if (!el || !window.FortifyPasskeys || !FortifyPasskeys.isSupported()) {
        return;
    }

    if (typeof window.PublicKeyCredential.isConditionalMediationAvailable !== 'function') {
        return;
    }

    if (!document.querySelector('input[autocomplete*="webauthn"]')) {
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

    window.PublicKeyCredential.isConditionalMediationAvailable()
        .then(function (available) {
            if (!available) {
                return null;
            }

            return fetch(el.dataset.optionsUrl, {
                method: 'GET',
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin',
            });
        })
        .then(function (response) {
            if (!response) {
                return null;
            }

            if (!response.ok) {
                throw new Error('Unable to fetch passkey login options.');
            }

            return response.json();
        })
        .then(function (response) {
            if (!response) {
                return null;
            }

            return navigator.credentials.get({
                publicKey: FortifyPasskeys.toPublicKeyCredentialRequestOptions(response.options),
                mediation: 'conditional',
            });
        })
        .then(function (credential) {
            if (!credential) {
                return null;
            }

            var remember = document.querySelector('input[name="remember"]');

            return fetch(el.dataset.loginUrl, {
                method: 'POST',
                headers: csrfHeaders(),
                credentials: 'same-origin',
                body: JSON.stringify({
                    credential: FortifyPasskeys.serializeCredential(credential),
                    remember: remember ? remember.checked : false,
                }),
            });
        })
        .then(function (response) {
            if (!response || !response.ok) {
                throw new Error('Unable to login with passkey.');
            }

            return response.json();
        })
        .then(function (body) {
            window.location.href = body && body.redirect ? body.redirect : window.location.href;
        })
        .catch(function () {
            // Passkey autofill failed or was cancelled; the user can sign in with the password form.
        });
})();
