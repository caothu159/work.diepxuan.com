'use strict';

// DXLAB: Update cache names any time any of the cached files change.
const CACHE_NAME = 'static-cache-v1.02';

// DXLAB: Add list of files to cache here.
const FILES_TO_CACHE = [
    '/',
    '/js/work.js',
    '/css/app.css'
];
const FILES_NOT_CACHE = [
    '/token',
    '/css/app.css',
    '/js/work.js',
    '/api/v1/hdbh',
];

self.addEventListener('install', (event) => {
    // console.log("[Service Worker] Installing Service Worker ", event);
    // DXLAB: Precache static resources here.
    // event.waitUntil(
    //     caches.open(CACHE_NAME).then((cache) => {
    //         // console.log("[Service Worker] Pre-caching page");
    //         return cache.addAll(FILES_TO_CACHE);
    //     })
    // );

    event.waitUntil(self.skipWaiting());
});

self.addEventListener('activate', (event) => {
    // console.log("[Service Worker] Activating Service Worker ", event);
    // DXLAB: Remove previous cached data from disk.
    event.waitUntil(
        caches.keys().then((keyLst) => {
            return Promise.all(
                keyLst
                .filter(key => key !== CACHE_NAME)
                .map((key) => {
                    // console.log("[Service Worker] Removing old cache", key);
                    return caches.delete(key);
                })
            );
        })
    );

    return self.clients.claim();
});

self.addEventListener('fetch', (event) => {
    if (event.request.cache === 'only-if-cached' && event.request.mode !== 'same-origin') {
        return;
    }

    if (new URL(event.request.url).hostname !== 'work.diepxuan.com') {
        event.respondWith(fetch(event.request).catch((err) => {}));
        return;
    }

    // DXLAB: Add fetch event handler here.
    if (FILES_NOT_CACHE.includes(new URL(event.request.url).pathname)) {
        event.respondWith(fetch(event.request));
        return;
    }


    // DXLAB: cache first
    // event.respondWith(
    //     caches.open(CACHE_NAME).then((cache) => {
    //         return cache.match(event.request).then((response) => {
    //             return response || fetch(event.request).then((response) => {
    //                 if (!response || response.status !== 200 || response.type !== 'basic') {
    //                     return response;
    //                 }

    //                 if (FILES_NOT_CACHE.includes(new URL(event.request.url).pathname)) {
    //                     return response;
    //                 }
    //                 // [1, 2, 3].includes(2);

    //                 cache.put(event.request, response.clone());
    //                 return response;
    //             });
    //         });
    //     })
    // );
    // event.respondWith(
    //     caches.open(CACHE_NAME).then((cache) => {
    //         return cache.match(event.request).then((response) => {
    //             return response;
    //         });
    //     })
    // );

    event.respondWith(
        caches.open(CACHE_NAME).then(function(cache) {
            return cache.match(event.request).then(function(response) {
                return response || fetch(event.request).then((response) => {
                    if (!response || response.status !== 200 || response.type !== 'basic') {
                        return response;
                    }

                    cache.put(event.request, response.clone());
                    return response;
                });
            });
        })
    );

    // DXLAB: request first
    // event.respondWith(
    //     caches.open(CACHE_NAME).then(function(cache) {
    //         return fetch(event.request).then(function(response) {
    //                 cache.put(event.request, response.clone());
    //                 return response;
    //             })
    //             .catch(() => {
    //                 return cache.match(event.request).then((response) => {
    //                     return response;
    //                 });
    //             });
    //     })
    // );

});
