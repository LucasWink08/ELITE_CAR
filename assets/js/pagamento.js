(() => {
    const painel = document.getElementById('simulador');
    const entradaInput = document.getElementById('entrada');
    const entradaRange = document.getElementById('entrada-range');
    const percentualEntrada = document.getElementById('entrada-percentual');
    const opcoes = document.getElementById('opcoes-parcelamento');
    const aviso = document.getElementById('aviso-simulacao');
    if (!painel || !entradaInput || !entradaRange || !opcoes || !aviso) return;

    const preco = Number(painel.dataset.preco);
    const taxaAnualReferencia = Number(painel.dataset.taxaAnual);
    const taxaMensalFixa = Math.pow(1 + taxaAnualReferencia / 100, 1 / 12) - 1;
    const prazos = [12, 24, 36, 48, 60];
    const moeda = valor => new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(valor);
    const percentual = valor => new Intl.NumberFormat('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(valor);

    const criarLinha = (rotulo, valor, total = false) => {
        const linha = document.createElement('div');
        linha.className = `payment-result__line${total ? ' payment-result__line--total' : ''}`;
        const nome = document.createElement('span');
        nome.textContent = rotulo;
        const quantia = document.createElement('strong');
        quantia.textContent = valor;
        linha.append(nome, quantia);
        return linha;
    };

    function atualizar() {
        const entrada = Number(entradaInput.value);
        const entradaInvalida = entradaInput.value.trim() === '' || !Number.isFinite(entrada) || entrada < 0 || entrada > preco;

        if (entradaInvalida) {
            aviso.textContent = 'Informe uma entrada entre R$ 0,00 e o preço do veículo.';
            aviso.hidden = false;
            opcoes.replaceChildren();
            return;
        }

        aviso.hidden = true;
        const saldo = Math.max(0, preco - entrada);
        const taxa = taxaMensalFixa;
        const anual = (Math.pow(1 + taxa, 12) - 1) * 100;
        const percEntrada = preco > 0 ? (entrada / preco) * 100 : 0;

        document.getElementById('resumo-entrada').textContent = moeda(entrada);
        document.getElementById('saldo-financiado').textContent = moeda(saldo);
        document.getElementById('juros-anual').textContent = `${percentual(anual)}% a.a.`;
        percentualEntrada.textContent = `${percentual(percEntrada)}%`;
        entradaRange.value = String(Math.round(percEntrada));
        opcoes.replaceChildren();

        prazos.forEach(prazo => {
            const parcelaSemArredondar = saldo === 0
                ? 0
                : taxa === 0
                    ? saldo / prazo
                    : saldo * taxa / (1 - Math.pow(1 + taxa, -prazo));
            const parcela = Math.round((parcelaSemArredondar + Number.EPSILON) * 100) / 100;
            const totalParcelas = Math.round(parcela * prazo * 100) / 100;
            const totalJuros = Math.max(0, Math.round((totalParcelas - saldo) * 100) / 100);
            const totalComEntrada = Math.round((totalParcelas + entrada) * 100) / 100;

            const card = document.createElement('article');
            card.className = 'payment-result';
            const prazoLabel = document.createElement('p');
            prazoLabel.className = 'payment-result__term';
            prazoLabel.textContent = `${prazo} meses`;
            const valorParcela = document.createElement('strong');
            valorParcela.className = 'payment-result__installment';
            valorParcela.textContent = `${moeda(parcela)} / mês`;
            card.append(prazoLabel, valorParcela);
            card.append(
                criarLinha('Total de juros', moeda(totalJuros)),
                criarLinha('Total das parcelas', moeda(totalParcelas)),
                criarLinha('Total com entrada', moeda(totalComEntrada), true)
            );
            opcoes.append(card);
        });
    }

    entradaInput.addEventListener('input', atualizar);
    entradaRange.addEventListener('input', () => {
        entradaInput.value = ((preco * Number(entradaRange.value)) / 100).toFixed(2);
        atualizar();
    });
    atualizar();
})();
