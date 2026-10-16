<?php
declare(strict_types=1);

function luxcarsCadastroEscape(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

$etapaInicial = $_SERVER['REQUEST_METHOD'] === 'POST'
    && $erros !== []
    && ($_POST['etapa'] ?? null) === '2'
        ? 2
        : 1;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxCars | Cadastro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/fonte.css">
    <link rel="stylesheet" href="../assets/css/site.css">
</head>
<body class="min-h-screen bg-gradient-to-t from-black to-gray-900 text-white">
<?php require dirname(__DIR__, 3) . '/includes/navbar.php'; ?>
<main class="luxcars-auth-shell luxcars-auth-shell--signup" aria-label="Crie sua conta LuxCars">
    <aside class="luxcars-auth-aside">
        <div>
            <span class="luxcars-auth-mark">LuxCars &middot; acesso exclusivo</span>
            <h2>Uma experiência feita para quem valoriza cada detalhe.</h2>
            <p>Crie sua conta para salvar seus veículos favoritos, comparar modelos e acompanhar suas solicitações.</p>
        </div>
        <p class="luxcars-auth-aside-foot">Seu próximo carro começa com uma escolha.</p>
    </aside>
    <section class="luxcars-auth-form luxcars-auth-form--signup">
        <p class="luxcars-auth-kicker">Cadastro de cliente</p>
        <h1>Criar conta</h1>
        <p class="luxcars-auth-intro">Preencha seus dados para começar sua experiência LuxCars.</p>

        <?php if ($sucesso !== null): ?>
            <p class="mb-5 rounded bg-green-100 p-4 text-green-900" role="status"><?= luxcarsCadastroEscape($sucesso) ?> <a class="underline" href="entrar.php">Ir para o login</a></p>
        <?php endif; ?>
        <?php if ($erros !== []): ?>
            <div class="mb-5 rounded bg-red-100 p-4 text-red-900" role="alert">
                <p class="mb-2 font-semibold">Revise os dados informados:</p>
                <ul class="list-inside list-disc">
                    <?php foreach (array_unique($erros) as $erro): ?><li><?= luxcarsCadastroEscape($erro) ?></li><?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form id="form-cadastro" action="cadastro.php" method="post" class="luxcars-signup-form" data-initial-step="<?= $etapaInicial ?>">
            <input type="hidden" name="etapa" id="cadastro-etapa" value="<?= $etapaInicial ?>">
            <div class="luxcars-signup-progress" aria-label="Progresso do cadastro">
                <ol>
                    <li data-signup-indicator="1"><span>01</span><span>Dados pessoais</span></li>
                    <li data-signup-indicator="2"><span>02</span><span>Endere&ccedil;o e acesso</span></li>
                </ol>
                <div class="luxcars-signup-progress__track" role="progressbar" aria-label="Etapas conclu&iacute;das" aria-valuemin="1" aria-valuemax="2" aria-valuenow="1" data-signup-progress>
                    <span></span>
                </div>
                <p data-signup-step-label aria-live="polite">Etapa 1 de 2</p>
            </div>

            <div class="luxcars-signup-step" data-signup-panel="1">
                <div class="luxcars-signup-step__heading">
                    <h2>Dados pessoais</h2>
                    <p>Informe seus dados de identifica&ccedil;&atilde;o e contato.</p>
                </div>
            <label class="grid gap-1 sm:col-span-2">Nome completo
                <input class="rounded border border-gray-300 p-3" type="text" name="nome" maxlength="150" autocomplete="name" required value="<?= luxcarsCadastroEscape($dados['nome']) ?>">
            </label>
            <label class="grid gap-1">CPF
                <input id="cpf" class="rounded border border-gray-300 p-3" type="text" name="cpf" inputmode="numeric" autocomplete="off" maxlength="14" placeholder="000.000.000-00" aria-describedby="ajuda-cpf" required value="<?= luxcarsCadastroEscape($dados['cpf']) ?>">
                <span id="ajuda-cpf" class="text-xs text-gray-600">Digite os 11 números do CPF.</span>
            </label>
            <label class="grid gap-1">Data de nascimento
                <input id="data_nascimento" class="rounded border border-gray-300 p-3" type="date" name="data_nascimento" autocomplete="bday" required value="<?= luxcarsCadastroEscape($dados['data_nascimento']) ?>">
                <span id="erro-idade" class="hidden text-sm text-red-700" role="alert">É necessário ter pelo menos 18 anos para criar uma conta.</span>
            </label>
            <label class="grid gap-1">E-mail
                <input class="rounded border border-gray-300 p-3" type="email" name="email" maxlength="190" autocomplete="email" required value="<?= luxcarsCadastroEscape($dados['email']) ?>">
            </label>
            <label class="grid gap-1">Telefone
                <input id="telefone" class="rounded border border-gray-300 p-3" type="tel" name="telefone" inputmode="tel" autocomplete="tel" minlength="14" maxlength="15" placeholder="(00) 00000-0000" aria-describedby="ajuda-telefone" required value="<?= luxcarsCadastroEscape($dados['telefone']) ?>">
                <span id="ajuda-telefone" class="text-xs text-gray-600">Inclua o DDD.</span>
            </label>
                <div class="luxcars-signup-actions sm:col-span-2">
                    <button class="luxcars-signup-button luxcars-signup-button--primary" type="button" data-signup-next>Continuar</button>
                </div>
            </div>

            <div class="luxcars-signup-step" data-signup-panel="2">
                <div class="luxcars-signup-step__heading">
                    <h2>Endere&ccedil;o e acesso</h2>
                    <p>Informe seu endere&ccedil;o e defina uma senha segura.</p>
                </div>
            <label class="grid gap-1 sm:col-span-2">Endereço
                <input class="rounded border border-gray-300 p-3" type="text" name="endereco" maxlength="180" autocomplete="street-address" required value="<?= luxcarsCadastroEscape($dados['endereco']) ?>">
            </label>
            <label class="grid gap-1">Número
                <input class="rounded border border-gray-300 p-3" type="text" name="numero_endereco" maxlength="20" required value="<?= luxcarsCadastroEscape($dados['numero_endereco']) ?>">
            </label>
            <label class="grid gap-1">Cidade
                <input class="rounded border border-gray-300 p-3" type="text" name="cidade" maxlength="100" autocomplete="address-level2" required value="<?= luxcarsCadastroEscape($dados['cidade']) ?>">
            </label>
            <label class="grid gap-1">Estado (UF)
                <input class="rounded border border-gray-300 p-3 uppercase" type="text" name="estado" pattern="[A-Za-z]{2}" minlength="2" maxlength="2" autocomplete="address-level1" required value="<?= luxcarsCadastroEscape($dados['estado']) ?>">
            </label>
            <label class="grid gap-1">Senha (mínimo 8 caracteres)
                <input class="rounded border border-gray-300 p-3" type="password" name="senha" minlength="8" autocomplete="new-password" required>
            </label>
            <label class="grid gap-1">Confirme a senha
                <input class="rounded border border-gray-300 p-3" type="password" name="confirmacao_senha" minlength="8" autocomplete="new-password" required>
            </label>
                <div class="luxcars-signup-actions luxcars-signup-actions--split sm:col-span-2">
                    <button class="luxcars-signup-button luxcars-signup-button--secondary" type="button" data-signup-back>Voltar</button>
                    <button class="luxcars-signup-button luxcars-signup-button--primary" type="submit">Criar conta</button>
                </div>
            </div>
        </form>
        <p class="mt-5 text-center">Já tem conta? <a class="font-semibold underline" href="entrar.php">Entrar</a></p>
    </section>
</main>
<script>
(() => {
    const form = document.getElementById('form-cadastro');
    const campoCpf = document.getElementById('cpf');
    const campoTelefone = document.getElementById('telefone');
    const campoNascimento = document.getElementById('data_nascimento');
    const mensagemIdade = document.getElementById('erro-idade');
    const paineisEtapa = Array.from(form.querySelectorAll('[data-signup-panel]'));
    const indicadoresEtapa = Array.from(form.querySelectorAll('[data-signup-indicator]'));
    const campoEtapa = document.getElementById('cadastro-etapa');
    const barraProgresso = form.querySelector('[data-signup-progress]');
    const rotuloEtapa = form.querySelector('[data-signup-step-label]');
    const senha = form.querySelector('[name="senha"]');
    const confirmacaoSenha = form.querySelector('[name="confirmacao_senha"]');
    let etapaAtual = Number(form.dataset.initialStep) === 2 ? 2 : 1;
    const hoje = new Date();
    const dataMaxima = new Date(hoje.getFullYear(), hoje.getMonth(), hoje.getDate());
    const limite = new Date(dataMaxima.getFullYear() - 18, dataMaxima.getMonth(), dataMaxima.getDate());
    const isoLocal = (data) => [data.getFullYear(), String(data.getMonth() + 1).padStart(2, '0'), String(data.getDate()).padStart(2, '0')].join('-');

    const mostrarEtapa = (etapa, focarTitulo = false) => {
        etapaAtual = etapa;
        campoEtapa.value = String(etapa);
        paineisEtapa.forEach((painel) => {
            const ativo = Number(painel.dataset.signupPanel) === etapa;
            painel.hidden = !ativo;
            painel.querySelectorAll('input, select, textarea, button').forEach((controle) => {
                if (Number(painel.dataset.signupPanel) === 2) {
                    controle.disabled = !ativo;
                } else {
                    controle.disabled = false;
                }
            });
        });
        indicadoresEtapa.forEach((indicador) => {
            const numero = Number(indicador.dataset.signupIndicator);
            const atual = numero === etapa;
            indicador.classList.toggle('is-current', atual);
            indicador.classList.toggle('is-complete', numero < etapa);
            if (atual) indicador.setAttribute('aria-current', 'step');
            else indicador.removeAttribute('aria-current');
        });
        barraProgresso.setAttribute('aria-valuenow', String(etapa));
        barraProgresso.querySelector('span').style.width = etapa === 1 ? '50%' : '100%';
        rotuloEtapa.textContent = `Etapa ${etapa} de 2`;

        if (focarTitulo) {
            const titulo = form.querySelector(`[data-signup-panel="${etapa}"] .luxcars-signup-step__heading h2`);
            titulo.setAttribute('tabindex', '-1');
            titulo.focus({ preventScroll: true });
        }
    };

    campoNascimento.max = isoLocal(dataMaxima);

    const validarIdade = () => {
        const nascimento = campoNascimento.value;
        const menorDeIdade = nascimento !== '' && nascimento > isoLocal(limite);
        campoNascimento.setCustomValidity(menorDeIdade ? 'É necessário ter pelo menos 18 anos.' : '');
        mensagemIdade.classList.toggle('hidden', !menorDeIdade);
        return !menorDeIdade;
    };

    const cpfValido = () => {
        const digitos = campoCpf.value.replace(/\D/g, '');
        if (digitos.length !== 11 || /^(\d)\1{10}$/.test(digitos)) return false;

        for (let posicao = 9; posicao <= 10; posicao += 1) {
            let soma = 0;
            for (let indice = 0; indice < posicao; indice += 1) {
                soma += Number(digitos[indice]) * ((posicao + 1) - indice);
            }
            const resto = (soma * 10) % 11;
            const digito = resto === 10 ? 0 : resto;
            if (Number(digitos[posicao]) !== digito) return false;
        }
        return true;
    };

    const validarEtapaPessoal = () => {
        validarIdade();
        campoCpf.setCustomValidity(cpfValido() ? '' : 'Informe um CPF v\u00e1lido.');
        const campos = paineisEtapa[0].querySelectorAll('input, select, textarea');
        const primeiroInvalido = Array.from(campos).find((campo) => !campo.checkValidity());
        if (primeiroInvalido) {
            primeiroInvalido.reportValidity();
            return false;
        }
        return true;
    };

    campoNascimento.addEventListener('input', validarIdade);
    campoNascimento.addEventListener('change', validarIdade);
    campoCpf.addEventListener('blur', () => {
        if (campoCpf.value !== '') campoCpf.setCustomValidity(cpfValido() ? '' : 'Informe um CPF v\u00e1lido.');
    });
    const validarConfirmacaoSenha = () => {
        confirmacaoSenha.setCustomValidity(
            confirmacaoSenha.value !== '' && confirmacaoSenha.value !== senha.value
                ? 'As senhas precisam ser iguais.'
                : ''
        );
    };
    senha.addEventListener('input', validarConfirmacaoSenha);
    confirmacaoSenha.addEventListener('input', validarConfirmacaoSenha);
    validarIdade();
    mostrarEtapa(etapaAtual);

    form.querySelector('[data-signup-next]').addEventListener('click', () => {
        if (validarEtapaPessoal()) mostrarEtapa(2, true);
    });
    form.querySelector('[data-signup-back]').addEventListener('click', () => mostrarEtapa(1, true));

    campoCpf.addEventListener('input', () => {
        const digitos = campoCpf.value.replace(/\D/g, '').slice(0, 11);
        campoCpf.value = digitos
            .replace(/^(\d{3})(\d)/, '$1.$2')
            .replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3')
            .replace(/\.(\d{3})(\d{1,2})$/, '.$1-$2');
        campoCpf.setCustomValidity('');
    });

    campoTelefone.addEventListener('input', () => {
        const digitos = campoTelefone.value.replace(/\D/g, '').slice(0, 11);
        if (digitos.length <= 10) {
            campoTelefone.value = digitos
                .replace(/^(\d{2})(\d)/, '($1) $2')
                .replace(/(\d{4})(\d)/, '$1-$2');
        } else {
            campoTelefone.value = digitos
                .replace(/^(\d{2})(\d)/, '($1) $2')
                .replace(/(\d{5})(\d)/, '$1-$2');
        }
    });
    form.addEventListener('submit', (evento) => {
        if (etapaAtual === 1) {
            evento.preventDefault();
            if (validarEtapaPessoal()) mostrarEtapa(2, true);
            return;
        }
        if (!validarIdade()) {
            evento.preventDefault();
            mostrarEtapa(1, true);
            campoNascimento.reportValidity();
        }
    });
})();
</script>
<?php require dirname(__DIR__, 3) . '/includes/footer.php'; ?>
</body>
</html>
