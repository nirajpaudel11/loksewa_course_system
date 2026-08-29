(function () {
    const paths = {
        'arrow-right': '<path d="M5 12h14"/><path d="m13 6 6 6-6 6"/>',
        award: '<circle cx="12" cy="8" r="6"/><path d="M9 14 7 22l5-3 5 3-2-8"/>',
        'bar-chart-3': '<path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/>',
        'book-open': '<path d="M2 4h7a3 3 0 0 1 3 3v13a3 3 0 0 0-3-3H2z"/><path d="M22 4h-7a3 3 0 0 0-3 3v13a3 3 0 0 1 3-3h7z"/>',
        calendar: '<path d="M8 2v4"/><path d="M16 2v4"/><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M3 10h18"/>',
        'check-circle': '<circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-5"/>',
        'check-circle-2': '<circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-5"/>',
        'chevron-down': '<path d="m6 9 6 6 6-6"/>',
        'chevron-right': '<path d="m9 18 6-6-6-6"/>',
        download: '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M7 10l5 5 5-5"/><path d="M12 15V3"/>',
        file: '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/>',
        'file-text': '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M8 13h8"/><path d="M8 17h8"/><path d="M8 9h2"/>',
        'help-circle': '<circle cx="12" cy="12" r="10"/><path d="M9.1 9a3 3 0 1 1 5.8 1c-.8 1.3-2.4 1.7-2.9 3"/><path d="M12 17h.01"/>',
        info: '<circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/>',
        'layout-grid': '<rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>',
        lightbulb: '<path d="M9 18h6"/><path d="M10 22h4"/><path d="M8 14a6 6 0 1 1 8 0c-.7.7-1 1.5-1 2H9c0-.5-.3-1.3-1-2z"/>',
        'log-in': '<path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><path d="M10 17l5-5-5-5"/><path d="M15 12H3"/>',
        'log-out': '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/>',
        lock: '<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
        'play-circle': '<circle cx="12" cy="12" r="10"/><path d="m10 8 6 4-6 4z"/>',
        quote: '<path d="M3 21c3-2 5-5 5-9V5H3v7h3c0 3-1 5-3 6z"/><path d="M14 21c3-2 5-5 5-9V5h-5v7h3c0 3-1 5-3 6z"/>',
        search: '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>',
        'search-x': '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/><path d="m8 8 6 6"/><path d="m14 8-6 6"/>',
        'shield-check': '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-5"/>',
        users: '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.8"/><path d="M16 3.1a4 4 0 0 1 0 7.8"/>',
        x: '<path d="M18 6 6 18"/><path d="m6 6 12 12"/>',
        'x-circle': '<circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/>'
    };

    window.renderIcons = function () {
        document.querySelectorAll('[data-lucide]').forEach((el) => {
            const name = el.getAttribute('data-lucide');
            const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            svg.setAttribute('viewBox', '0 0 24 24');
            svg.setAttribute('fill', 'none');
            svg.setAttribute('stroke', 'currentColor');
            svg.setAttribute('stroke-width', '2');
            svg.setAttribute('stroke-linecap', 'round');
            svg.setAttribute('stroke-linejoin', 'round');
            svg.setAttribute('class', el.getAttribute('class') || 'icon');
            svg.innerHTML = paths[name] || '<circle cx="12" cy="12" r="9"/>';
            el.replaceWith(svg);
        });
    };

    document.addEventListener('DOMContentLoaded', window.renderIcons);
})();
