/**
 * Get's the cached forecast data from the caches object.
 *
 * @param {string} coords Location object to.
 * @return {Object} The weather forecast, if the request fails, return null.
 */
function getForecastFromCache(coords) {
    // CODELAB: Add code to get weather forecast from the caches object.

    // kiểm tra trước khi thực hiện những việc tiếp theo
    if (!('caches' in window)) {
        return null;
    }
    const url = `${window.location.origin}/${coords}`;
    return caches
        .match(url)
        .then((response) => {
            if (response) {
                return response.json();
            }
            return null;
        })
        .catch((err) => {
            // console.error('Error getting data from cache', err);
            return null;
        });
}

window.addEventListener('load', () => {
    const base = document.querySelector('base');
    let baseUrl = (base && base.href) || '';
    if (!baseUrl.endsWith('/')) {
        baseUrl = `${baseUrl}/`;
    }

    if ('serviceWorker' in navigator) {
        navigator.serviceWorker
            .register(`${baseUrl}sw.js`, { scope: '/' })
            .then((registration) => {
                // Registration was successful
                // console.log('ServiceWorker registration successful with scope: ', registration.scope);
                registration.update();
            })
            .catch((err) => {
                // registration failed :(
                // console.log('ServiceWorker registration failed: ', err);
            });
    }
});
