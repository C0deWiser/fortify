(function () {
    'use strict';

    var el = document.getElementById('passkeyLogin');

    if (!el || !window.FortifyPasskeys || !FortifyPasskeys.isSupported()) {
        console.log('passkey login: not supported or #passkeyLogin missing');
        return;
    }

    if (typeof window.PublicKeyCredential.isConditionalMediationAvailable !== 'function') {
        console.log('passkey login: isConditionalMediationAvailable not available');
        return;
    }

    if (!document.querySelector('input[autocomplete*="webauthn"]')) {
        console.log('passkey login: no webauthn autocomplete input found');
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

    console.log('passkey login: checking conditional mediation availability');

    window.PublicKeyCredential.isConditionalMediationAvailable()
        .then(function (available) {
            if (!available) {
                console.log('passkey login: conditional mediation not available');
                return null;
            }

            console.log('passkey login: fetching login options from', el.dataset.optionsUrl);

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
                console.error('passkey login: failed to fetch options, status', response.status);
                throw new Error('Unable to fetch passkey login options.');
            }

            console.log('passkey login: options fetched successfully');
            return response.json();
        })
        .then(function (response) {
            if (!response) {
                return null;
            }

            console.log('passkey login: calling navigator.credentials.get');

            return navigator.credentials.get({
                publicKey: FortifyPasskeys.toPublicKeyCredentialRequestOptions(response.options),
                mediation: 'conditional',
            });
        })
        .then(function (credential) {
            if (!credential) {
                console.log('passkey login: no credential received (user cancelled?)');
                return null;
            }

            console.log('passkey login: credential received, posting to', el.dataset.loginUrl);

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
            if (!response) {
                return null;
            }

            if (!response.ok) {
                return response.json().catch(function () {
                    return null;
                }).then(function (body) {
                    var message = (body && body.message) || 'Unable to login with passkey.';
                    console.error('passkey login: login failed -', message, body);
                    var target = document.querySelector('input[name="email"]');
                    if (target) {
                        var invalid = target.closest('div').querySelector('.invalid');
                        if (invalid) {
                            invalid.textContent = message;
                        }
                    }
                    throw new Error(message);
                });
            }

            console.log('passkey login: login successful');
            return response.json();
        })
        .then(function (body) {
            console.log('passkey login: redirecting to', body && body.redirect);
            window.location.href = body && body.redirect ? body.redirect : window.location.href;
        })
        .catch(function (error) {
            console.error('passkey login: error -', error);

            if (error && error.name === 'NotAllowedError') {
                return;
            }

            var message = error && error.message ? error.message : 'Passkey login failed.';
            var target = document.querySelector('input[name="email"]');
            if (target) {
                var invalid = target.closest('div').querySelector('.invalid');
                if (invalid) {
                    invalid.textContent = message;
                }
            }
        });
})();
