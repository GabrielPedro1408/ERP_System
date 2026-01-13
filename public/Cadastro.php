<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neo Gestão - Cadastro</title>
    <link rel="stylesheet" href="./assets/css/cadastro.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/scrollreveal@4.0.9/dist/scrollreveal.min.js"></script>
</head>
<body>
    <!-- Background Animation -->
    <div class="background-animation">
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>
        <div class="floating-shape shape-4"></div>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo">
                <a href="index.php"><img src="./assets/images/financeiro.png" alt="logo"></a>
                <span>Neo Gestão</span>
            </div>
            <nav class="nav">
                <a href="Index.php" class="nav-link">Início</a>
                <a href="Login.php" class="nav-link">Entrar</a>
                <a href="Cadastro.php" class="nav-link active">Cadastrar</a>
            </nav>
        </div>
    </header>

    <!-- Main Container -->
    <div class="main-container">
        <div class="cadastro-container">
            <!-- Progress Bar -->
            <div class="progress-container">
                <div class="progress-step active" data-step="1">
                    <?php
                    if (isset($_SESSION['message'])):
                        $type = isset($_SESSION['message_type']) ? $_SESSION['message_type'] : 'info';
                    ?>
                        <div class="alert alert-<?= $type ?> alert-dismissible fade show alert-top-fixed" role="alert">
                            <?= $_SESSION['message'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                        unset($_SESSION['message']);
                        unset($_SESSION['message_type']);
                    endif;
                    ?>
                    <div class="step-number">1</div>
                    <span class="step-label">Empresa</span>
                </div>
                <div class="progress-line">
                    <div class="progress-fill"></div>
                </div>
                <div class="progress-step" data-step="2">
                    <div class="step-number">2</div>
                    <span class="step-label">Usuário</span>
                </div>
                <div class="progress-line">
                    <div class="progress-fill"></div>
                </div>
                <div class="progress-step" data-step="3">
                    <div class="step-number">3</div>
                    <span class="step-label">Finalização</span>
                </div>
            </div>

            <!-- Form Container -->
            <div class="form-container">
                <form action="../app/Controllers/CadastroController.php" method="POST" class="cadastro-form" id="cadastroForm">
                    
                    <!-- Step 1: Informações da Empresa -->
                    <div class="step-content active" data-step="1">
                        <div class="step-header">
                            <div class="step-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <h2>Informações da Empresa</h2>
                            <p>Preencha os dados da sua empresa</p>
                        </div>

                        <div class="form-grid">
                            <div class="input-group">
                                <label for="razaoSocial">Razão Social</label>
                                <div class="input-field">
                                    <i class="fas fa-building"></i>
                                    <input type="text" id="razaoSocial" name="razaoSocial" placeholder="Ex: NeoGestão Ltda" required>
                                </div>
                            </div>

                            <div class="input-group">
                                <label for="emailEmpresa">Email</label>
                                <div class="input-field">
                                    <i class="fas fa-envelope"></i>
                                    <input type="email" id="emailEmpresa" name="emailEmpresa" placeholder="Ex: contato@empresa.com" required>
                                </div>
                            </div>

                            <div class="input-group">
                                <label for="telefoneEmpresa">Telefone</label>
                                <div class="input-field">
                                    <i class="fas fa-phone"></i>
                                    <input type="tel" id="telefoneEmpresa" name="telefoneEmpresa" placeholder="Ex: (11) 91234-5678" maxlength="15" required>
                                </div>
                            </div>

                            <div class="input-group">
                                <label for="cnpjEmpresa">CNPJ</label>
                                <div class="input-field">
                                    <i class="fas fa-id-card"></i>
                                    <input type="text" id="cnpjEmpresa" name="cnpjEmpresa" placeholder="Ex: 12.345.678/0001-99" maxlength="18" required>
                                </div>
                            </div>

                            <div class="input-group">
                                <label for="cepEmpresa">CEP</label>
                                <div class="input-field">
                                    <i class="fas fa-map-pin"></i>
                                    <input type="text" id="cepEmpresa" name="cepEmpresa" placeholder="Ex: 12345-678" maxlength="9" required>
                                </div>
                            </div>

                            <div class="input-group">
                                <label for="ufEmpresa">UF</label>
                                <div class="input-field">
                                    <i class="fas fa-flag"></i>
                                    <input type="text" id="ufEmpresa" name="ufEmpresa" placeholder="Ex: SP" maxlength="2" required>
                                </div>
                            </div>

                             <div class="input-group">
                                <label for="cidadeEmpresa">Cidade</label>
                                <div class="input-field">
                                    <i class="fas fa-city"></i>
                                    <input type="text" id="cidadeEmpresa" name="cidadeEmpresa" placeholder="Ex: São Paulo" required>
                                </div>
                            </div>

                            <div class="input-group">
                                <label for="ruaEmpresa">Rua</label>
                                <div class="input-field">
                                    <i class="fas fa-road"></i>
                                    <input type="text" id="ruaEmpresa" name="ruaEmpresa" placeholder="Ex: Av. Paulista" required>
                                </div>
                            </div>

                            <div class="input-group">
                                <label for="numeroEmpresa">Número</label>
                                <div class="input-field">
                                    <i class="fas fa-hashtag"></i>
                                    <input type="text" id="numeroEmpresa" name="numeroEmpresa" placeholder="Ex: 123" required>
                                </div>
                            </div>

                            <div class="input-group">
                                <label for="complementoEmpresa">Complemento</label>
                                <div class="input-field">
                                    <i class="fas fa-hashtag"></i>
                                    <input type="text" id="complementoEmpresa" name="complementoEmpresa" placeholder="Ex: Apmnt. 23">
                                </div>
                            </div>

                        </div>

                        <div class="step-buttons">
                            <button type="button" class="btn-next" onclick="nextStep()">
                                Próximo
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Cadastro de Usuário -->
                    <div class="step-content" data-step="2">
                        <div class="step-header">
                            <div class="step-icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <h2>Cadastro de Usuário</h2>
                            <p>Crie suas credenciais de acesso</p>
                        </div>

                        <div class="form-grid centered">
                            <div class="input-group">
                                <label for="usuario">Nome de Usuário</label>
                                <div class="input-field">
                                    <i class="fas fa-user"></i>
                                    <input type="text" id="usuario" name="nomeUsuario" placeholder="Ex: joaosilva" required>
                                </div>
                            </div>

                            <div class="input-group">
                                <label for="senhaUsuario">Senha</label>
                                <div class="input-field">
                                    <i class="fas fa-lock"></i>
                                    <input type="password" id="senhaUsuario" name="senhaUsuario" placeholder="Digite sua senha" required>
                                    <button type="button" class="toggle-password" onclick="togglePassword('senhaUsuario')">
                                        <i class="fas fa-eye" id="toggleIcon1"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="input-group">
                                <label for="confirmarSenha">Confirmar Senha</label>
                                <div class="input-field">
                                    <i class="fas fa-lock"></i>
                                    <input type="password" id="confirmarSenha" name="confirmarSenha" placeholder="Confirme sua senha" required>
                                    <button type="button" class="toggle-password" onclick="togglePassword('confirmarSenha')">
                                        <i class="fas fa-eye" id="toggleIcon2"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="password-requirements">
                                <h4>Requisitos da senha:</h4>
                                <ul>
                                    <li id="length">Mínimo 8 caracteres</li>
                                    <li id="uppercase">Uma letra maiúscula</li>
                                    <li id="lowercase">Uma letra minúscula</li>
                                    <li id="number">Um número</li>
                                </ul>
                            </div>
                        </div>

                        <div class="step-buttons">
                            <button type="button" class="btn-prev" onclick="prevStep()">
                                <i class="fas fa-arrow-left"></i>
                                Voltar
                            </button>
                            <button type="button" class="btn-next" onclick="nextStep()">
                                Próximo
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Finalização -->
                    <div class="step-content" data-step="3">
                        <div class="step-header">
                            <div class="step-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <h2>Finalização</h2>
                            <p>Revise suas informações e conclua o cadastro</p>
                        </div>

                        <div class="summary-container">
                            <div class="summary-section">
                                <h3><i class="fas fa-building"></i> Dados da Empresa</h3>
                                <div class="summary-grid">
                                    <div class="summary-item">
                                        <span class="label">Razão Social:</span>
                                        <span class="value" id="summaryRazaoSocial">-</span>
                                    </div>
                                    <div class="summary-item">
                                        <span class="label">Email:</span>
                                        <span class="value" id="summaryEmail">-</span>
                                    </div>
                                    <div class="summary-item">
                                        <span class="label">CNPJ:</span>
                                        <span class="value" id="summaryCnpj">-</span>
                                    </div>
                                    <div class="summary-item">
                                        <span class="label">Telefone:</span>
                                        <span class="value" id="summaryTelefone">-</span>
                                    </div>
                                </div>
                            </div>

                            <div class="summary-section">
                                <h3><i class="fas fa-user"></i> Dados do Usuário</h3>
                                <div class="summary-grid">
                                    <div class="summary-item">
                                        <span class="label">Usuário:</span>
                                        <span class="value" id="summaryUsuario">-</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="terms-container">
                                <label class="terms-checkbox">
                                    <input type="checkbox" name="terms" required>
                                    <span class="checkmark"></span>
                                    Aceito os  <a href="#" target="_blank">termos de uso </a> e <a href="#" target="_blank"> política de privacidade</a>
                                </label>
                            </div>
                        <div class="step-buttons">
                            <button type="button" class="btn-prev" onclick="prevStep()">
                                <i class="fas fa-arrow-left"></i>
                                Voltar
                            </button>
                            <button type="submit" class="btn-submit" name="Cadastrar">
                                <i class="fas fa-check"></i>
                                Concluir Cadastro
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal-overlay" id="successModal">
        <div class="modal-content">
            <div class="modal-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2>Cadastro Realizado com Sucesso!</h2>
            <p>Sua conta foi criada. Você será redirecionado para o login.</p>
            <button class="btn-modal" onclick="redirectToLogin()">
                Ir para Login
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner">
            <div class="spinner"></div>
            <span>Processando cadastro...</span>
        </div>
    </div>

    <script src="assets/js/cadastro.js"></script>
</body>
</html>