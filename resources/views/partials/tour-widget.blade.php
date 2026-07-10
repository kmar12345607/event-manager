{{--
    Widget de guide interactif (bouton d'aide flottant + Intro.js).
    À inclure juste avant </body> sur les pages qui n'utilisent PAS
    layouts/public.blade.php (elles ont leur propre <html>/<body>),
    par exemple les pages d'authentification.

    Il suffit d'ajouter des attributs data-step="1", data-intro="...",
    data-title="..." sur les éléments à expliquer, dans l'ordre voulu.
--}}
<link href="https://cdn.jsdelivr.net/npm/intro.js/minified/introjs.min.css" rel="stylesheet">

<style>
    .help-float-btn {
        position: fixed; bottom: 28px; right: 28px; z-index: 9999;
        width: 58px; height: 58px; border-radius: 50%;
        background: linear-gradient(135deg, #1a237e, #1565c0); color: white;
        border: none; box-shadow: 0 10px 30px rgba(26,35,126,0.45);
        font-size: 1.4rem; display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all 0.3s;
        animation: helpPulse 2.5s infinite;
    }
    .help-float-btn:hover { transform: scale(1.08); box-shadow: 0 14px 36px rgba(26,35,126,0.6); }
    @keyframes helpPulse {
        0%, 100% { box-shadow: 0 10px 30px rgba(26,35,126,0.45); }
        50% { box-shadow: 0 10px 30px rgba(26,35,126,0.45), 0 0 0 10px rgba(26,35,126,0.12); }
    }
    .introjs-tooltip { border-radius: 16px; font-family: 'Segoe UI', sans-serif; box-shadow: 0 20px 50px rgba(13,27,75,0.25); max-width: 340px; }
    .introjs-tooltiptext { font-size: 0.92rem; color: #333; line-height: 1.6; }
    .introjs-tooltip-title { font-weight: 800; color: #0d1b4b; }
    .introjs-button {
        border-radius: 25px !important; font-weight: 700 !important; font-size: 0.85rem !important;
        padding: 8px 18px !important; text-shadow: none !important; border: none !important;
    }
    .introjs-nextbutton, .introjs-donebutton {
        background: linear-gradient(135deg, #1a237e, #1565c0) !important; color: white !important;
    }
    .introjs-prevbutton { background: #eceff8 !important; color: #555 !important; }
    .introjs-skipbutton { color: #9e9e9e !important; }
    .introjs-progress { border-radius: 10px !important; }
    .introjs-progressbar { background: linear-gradient(90deg,#1a237e,#1565c0) !important; }
    .introjs-helperNumberLayer {
        background: linear-gradient(135deg, #1a237e, #1565c0) !important;
        box-shadow: 0 3px 10px rgba(26,35,126,0.4) !important;
    }
</style>

<button class="help-float-btn" id="helpTourBtn" title="Besoin d'aide ? Lancer la visite guidée" onclick="startGuidedTour()">
    <i class="bi bi-question-lg"></i>
</button>

<script src="https://cdn.jsdelivr.net/npm/intro.js/minified/intro.min.js"></script>
<script>
function startGuidedTour() {
    introJs().setOptions({
        nextLabel: 'Suivant →',
        prevLabel: '← Précédent',
        doneLabel: 'Terminer',
        skipLabel: '✕',
        showProgress: true,
        showBullets: false,
        exitOnOverlayClick: true,
        overlayOpacity: 0.65,
        scrollToElement: true,
        disableInteraction: false
    }).start();
}

document.addEventListener('DOMContentLoaded', function () {
    var pageKey = window.location.pathname.replace(/[^a-z0-9]/gi, '_') || 'home';
    var storageKey = 'evt_tour_seen_' + pageKey;

    if (document.querySelectorAll('[data-step]').length && !localStorage.getItem(storageKey)) {
        setTimeout(startGuidedTour, 700);
        localStorage.setItem(storageKey, '1');
    }
});
</script>
