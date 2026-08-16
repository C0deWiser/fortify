window.FortifyPasskeys = (function () {
    'use strict';

    function isSupported() {
        return typeof window.PublicKeyCredential === 'function';
    }

    function fromBase64Url(value) {
        var base64 = value.replace(/-/g, '+').replace(/_/g, '/');
        var padding = (4 - (base64.length % 4)) % 4;
        var binary = atob(base64.padEnd(base64.length + padding, '='));
        var bytes = new Uint8Array(binary.length);

        for (var i = 0; i < binary.length; i++) {
            bytes[i] = binary.charCodeAt(i);
        }

        return bytes;
    }

    function toBase64Url(buffer) {
        var bytes = new Uint8Array(buffer);
        var binary = '';

        for (var i = 0; i < bytes.length; i++) {
            binary += String.fromCharCode(bytes[i]);
        }

        return btoa(binary)
            .replace(/\+/g, '-')
            .replace(/\//g, '_')
            .replace(/=+$/, '');
    }

    function toPublicKeyCredentialCreationOptions(options) {
        options.challenge = fromBase64Url(options.challenge);
        options.user.id = fromBase64Url(options.user.id);

        if (Array.isArray(options.excludeCredentials)) {
            options.excludeCredentials.forEach(function (descriptor) {
                descriptor.id = fromBase64Url(descriptor.id);
            });
        }

        return options;
    }

    function toPublicKeyCredentialRequestOptions(options) {
        options.challenge = fromBase64Url(options.challenge);

        if (Array.isArray(options.allowCredentials)) {
            options.allowCredentials.forEach(function (descriptor) {
                descriptor.id = fromBase64Url(descriptor.id);
            });
        }

        return options;
    }

    function serializeCredential(credential) {
        var clientExtensionResults = typeof credential.getClientExtensionResults === 'function'
            ? credential.getClientExtensionResults()
            : {};

        if (typeof credential.toJSON === 'function') {
            var json = credential.toJSON();

            if (Object.keys(clientExtensionResults).length) {
                json.clientExtensionResults = clientExtensionResults;
            }

            return json;
        }

        var response = credential.response;
        var serializedResponse = {};

        Object.keys(response).forEach(function (key) {
            serializedResponse[key] = toBase64Url(response[key]);
        });

        if (typeof response.getTransports === 'function') {
            serializedResponse.transports = response.getTransports();
        }

        return {
            id: credential.id,
            rawId: toBase64Url(credential.rawId),
            type: credential.type,
            authenticatorAttachment: credential.authenticatorAttachment,
            response: serializedResponse,
            clientExtensionResults: clientExtensionResults,
        };
    }

    function csrfHeader(form) {
        var meta = document.querySelector('meta[name="csrf-token"]');

        if (meta && meta.getAttribute('content')) {
            return { 'X-CSRF-TOKEN': meta.getAttribute('content') };
        }

        var input = form ? form.querySelector('input[name="_token"]') : null;

        if (input && input.value) {
            return { 'X-CSRF-TOKEN': input.value };
        }

        var cookie = document.cookie
            .split('; ')
            .find(function (cookie) { return cookie.indexOf('XSRF-TOKEN=') === 0; });

        if (cookie) {
            return { 'X-XSRF-TOKEN': decodeURIComponent(cookie.slice('XSRF-TOKEN='.length)) };
        }

        return {};
    }

    function describeUnsupported() {
        if (typeof window.PublicKeyCredential !== 'function') {
            if (window.isSecureContext === false) {
                return 'Passkeys require a secure context. This page is not served over HTTPS or localhost.';
            }

            return 'Passkeys are not supported in this browser. The WebAuthn API (PublicKeyCredential) is unavailable.';
        }

        if (typeof navigator.credentials === 'undefined' || !navigator.credentials) {
            return 'Passkeys are not supported in this browser. The Credentials Management API is unavailable.';
        }

        return 'Passkeys are not supported in this browser.';
    }

    function describeError(reason) {
        if (reason instanceof DOMException && reason.name === 'NotAllowedError') {
            return null;
        }

        if (reason instanceof DOMException && reason.name === 'SecurityError') {
            return 'Passkeys cannot be used on this domain. Use HTTPS or localhost.';
        }

        return reason && reason.message ? reason.message : 'Unable to register a passkey.';
    }

    return {
        isSupported: isSupported,
        describeUnsupported: describeUnsupported,
        toPublicKeyCredentialCreationOptions: toPublicKeyCredentialCreationOptions,
        toPublicKeyCredentialRequestOptions: toPublicKeyCredentialRequestOptions,
        serializeCredential: serializeCredential,
        describeError: describeError,
        csrfHeader: csrfHeader,
    };
})();
