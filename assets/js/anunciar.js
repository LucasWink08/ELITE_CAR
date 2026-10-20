(() => {
    const form = document.querySelector('[data-anuncio-form]');
    if (!form) return;

    const panels = Array.from(form.querySelectorAll('[data-anuncio-panel]'));
    const indicators = Array.from(document.querySelectorAll('[data-step-indicator]'));
    const progress = document.querySelector('[data-anuncio-progress]');
    const back = form.querySelector('[data-anuncio-back]');
    const next = form.querySelector('[data-anuncio-next]');
    const submit = form.querySelector('[data-anuncio-submit]');
    const photosInput = form.querySelector('[data-anuncio-photos]');
    const preview = form.querySelector('[data-anuncio-preview]');
    let current = 0;
    let previewUrls = [];

    const setStep = (index) => {
        current = Math.max(0, Math.min(index, panels.length - 1));
        panels.forEach((panel, panelIndex) => {
            const active = panelIndex === current;
            panel.hidden = !active;
            panel.classList.toggle('is-active', active);
        });
        indicators.forEach((indicator, indicatorIndex) => {
            indicator.classList.toggle('is-active', indicatorIndex === current);
            indicator.classList.toggle('is-done', indicatorIndex < current);
            if (indicatorIndex === current) indicator.setAttribute('aria-current', 'step');
            else indicator.removeAttribute('aria-current');
        });
        if (progress) progress.style.width = `${((current + 1) / panels.length) * 100}%`;
        if (back) back.hidden = current === 0;
        if (next) next.hidden = current === panels.length - 1;
        if (submit) submit.hidden = current !== panels.length - 1;
    };

    const validarEtapa = () => {
        const fields = Array.from(panels[current].querySelectorAll('input, select, textarea'));
        for (const field of fields) {
            if (field.disabled || field.type === 'file' && field.files.length === 0 && !field.required) continue;
            if (!field.checkValidity()) {
                field.reportValidity();
                field.focus({ preventScroll: false });
                return false;
            }
        }
        return true;
    };

    next?.addEventListener('click', () => {
        if (validarEtapa()) setStep(current + 1);
    });
    back?.addEventListener('click', () => setStep(current - 1));
    form.addEventListener('submit', (event) => {
        if (!validarEtapa()) {
            event.preventDefault();
            return;
        }
        if (submit) {
            submit.disabled = true;
            submit.textContent = 'Enviando arquivos…';
        }
    });

    photosInput?.addEventListener('change', () => {
        previewUrls.forEach(URL.revokeObjectURL);
        previewUrls = [];
        preview.replaceChildren();
        const files = Array.from(photosInput.files || []);
        if (files.length > 8) {
            photosInput.setCustomValidity('Selecione no máximo 8 fotos.');
            photosInput.reportValidity();
            photosInput.value = '';
            return;
        }
        photosInput.setCustomValidity('');
        files.forEach((file, index) => {
            const url = URL.createObjectURL(file);
            previewUrls.push(url);
            const figure = document.createElement('figure');
            const image = document.createElement('img');
            image.src = url;
            image.alt = `Prévia da foto ${index + 1}`;
            const caption = document.createElement('figcaption');
            caption.textContent = index === 0 ? `Capa · ${file.name}` : file.name;
            figure.append(image, caption);
            preview.append(figure);
        });
    });

    const showFileName = (inputSelector, labelSelector) => {
        const input = form.querySelector(inputSelector);
        const label = document.querySelector(labelSelector);
        input?.addEventListener('change', () => {
            if (label) label.textContent = input.files?.[0]?.name || 'Nenhum arquivo selecionado';
        });
    };
    showFileName('[data-anuncio-document]', '[data-document-name]');
    showFileName('[data-anuncio-extra-document]', '[data-extra-document-name]');
    setStep(0);
})();
