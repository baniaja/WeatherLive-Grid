import './bootstrap';
import { t, setLang, getLang, applyI18n, supportedLanguages } from './i18n';

// i18n global
window.WL = window.WL || {};
window.WL.t = t;
window.WL.setLang = setLang;
window.WL.getLang = getLang;
window.WL.applyI18n = applyI18n;
window.WL.supportedLanguages = supportedLanguages;

// Service Worker for PWA
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js').catch(err => {
            console.log('ServiceWorker registration failed: ', err);
        });
    });
}
