/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!****************************!*\
  !*** ./resources/js/sw.js ***!
  \****************************/
 // DXLAB: Update cache names any time any of the cached files change.

var CACHE_NAME = 'static-cache-v1.01'; // DXLAB: Add list of files to cache here.

var FILES_TO_CACHE = ['/', '/js/work.js', '/css/app.css'];
self.addEventListener('install', function (event) {
  // console.log("[Service Worker] Installing Service Worker ", event);
  // DXLAB: Precache static resources here.
  event.waitUntil(caches.open(CACHE_NAME).then(function (cache) {
    // console.log("[Service Worker] Pre-caching page");
    return cache.addAll(FILES_TO_CACHE);
  })); // event.waitUntil(self.skipWaiting());
});
self.addEventListener('activate', function (event) {
  // console.log("[Service Worker] Activating Service Worker ", event);
  // DXLAB: Remove previous cached data from disk.
  event.waitUntil(caches.keys().then(function (keyLst) {
    return Promise.all(keyLst.filter(function (key) {
      return key !== CACHE_NAME;
    }).map(function (key) {
      // console.log("[Service Worker] Removing old cache", key);
      return caches["delete"](key);
    }));
  }));
  return self.clients.claim();
});
self.addEventListener('fetch', function (event) {
  // This fixes a weird bug in Chrome when you open the Developer Tools
  if (event.request.cache === 'only-if-cached' && event.request.mode !== 'same-origin') {
    return;
  }

  if (new URL(event.request.url).hostname !== 'work.diepxuan.com') {
    event.respondWith(fetch(event.request));
    return;
  } // DXLAB: Add fetch event handler here.
  //DXLAB: cache first
  // event.respondWith(
  //     caches.match(event.request).then(function (response) {
  //         return response || fetch(event.request);
  //     })
  // );
  // DXLAB: request first


  event.respondWith(fetch(event.request).then(function (response) {
    caches.open(CACHE_NAME).then(function (cache) {
      console.log('[Service Worker] Pre-caching', new URL(event.request.url).pathname);
      return cache.add(new URL(event.request.url).pathname);
    });
    return response;
  })["catch"](function () {
    return caches.open(CACHE_NAME).then(function (cache) {
      return cache.match(event.request).then(function (response) {
        console.log('[Service Worker] Load from cache ', event.request.url);
        return response;
      });
    });
  }));
});
/******/ })()
;