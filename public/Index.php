
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neo Gestão - Gestão de Quadras</title>
    <link rel="stylesheet" href="./assets/css/index.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/scrollreveal@4.0.9/dist/scrollreveal.min.js"></script>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo">
                <a href="index.php"><img src="./assets/images/financeiro.png" alt="logo"></a>
                <span>Neo Gestão</span>
            </div>
            <nav class="nav">
                <a href="#inicio" class="nav-link">Início</a>
                <a href="#sobre" class="nav-link">Sobre</a>
                <a href="#planos" class="nav-link">Planos</a>
            </nav>
                <a href="Login.php" class="btn-login">Login</a>
        </div>
    </header>

    <!-- Seção Início -->
    <section id="inicio" class="hero">
        <div class="hero-background"></div>
        <div class="container">
            <div class="hero-content">
                <h2 class="hero-title">Neo Gestão</h2>
                <h4 class="hero-subtitle">
                    Revolucione a gestão da sua quadra esportiva com nossa plataforma completa. 
                    Controle reservas, pagamentos e clientes de forma simples e eficiente.
                </h4>
                <a href="Cadastro.php" class="btn-primary">Começar Agora</a>
            </div>
            
            <!-- Carousel -->
            <div class="carousel-container">
                <div class="carousel">
                    <div class="carousel-slide active">
                        <div class="slide-content">
                            <i class="fas fa-calendar-alt"></i>
                            <h3>Agendamento Inteligente</h3>
                            <p>Sistema automatizado de reservas com confirmação em tempo real</p>
                        </div>
                    </div>
                    <div class="carousel-slide">
                        <div class="slide-content">
                            <i class="fas fa-credit-card"></i>
                            <h3>Pagamentos Online</h3>
                            <p>Receba pagamentos de forma segura e automatizada</p>
                        </div>
                    </div>
                    <div class="carousel-slide">
                        <div class="slide-content">
                            <i class="fas fa-chart-line"></i>
                            <h3>Gráficos Detalhados</h3>
                            <p>Acompanhe o desempenho do seu negócio com gráficos precisos</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-dots">
                    <span class="dot active" onclick="currentSlide(1)"></span>
                    <span class="dot" onclick="currentSlide(2)"></span>
                    <span class="dot" onclick="currentSlide(3)"></span>
                </div>
            </div>
        </div>
    </section>

    <!-- Seção Sobre -->
    <section id="sobre" class="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2 class="section-title">Sobre a Neo Gestão</h2>
                    <p class="about-description">
                        Somos uma empresa especializada em soluções tecnológicas para gestão de quadras esportivas. 
                        Nossa missão é simplificar a administração do seu negócio, oferecendo ferramentas modernas 
                        e intuitivas que otimizam tempo e aumentam a rentabilidade.
                    </p>
                    <div class="features-grid">
                        <div class="feature-item">
                            <i class="fas fa-users"></i>
                            <div>
                                <h4>Gestão de Clientes</h4>
                                <p>Cadastro completo e histórico de reservas</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-mobile-alt"></i>
                            <div>
                                <h4>Site Responsivo</h4>
                                <p>Acesse de qualquer lugar, a qualquer hora</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-shield-alt"></i>
                            <div>
                                <h4>Segurança Total</h4>
                                <p>Seus dados protegidos com criptografia avançada</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-headset"></i>
                            <div>
                                <h4>Suporte Total</h4>
                                <p>Equipe sempre disponível por Email e WhatsApp</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <div class="image-placeholder">
                        <img src="./assets/images/gabaxx_vitaxx.jpeg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Seção Planos -->
    <section id="planos" class="plans">
        <div class="container">
            <h2 class="section-title">Escolha Seu Plano</h2>
            <p class="section-subtitle">Soluções personalizadas para cada tipo de negócio</p>
            
            <div class="plans-grid">
                <!-- Plano Bronze -->
                <div class="plan-card bronze">
                    <div class="plan-header">
                        <i class="fas fa-medal"></i>
                        <h3>Bronze</h3>
                        <div class="price">
                            <span class="currency">R$</span>
                            <span class="amount">99</span>
                            <span class="period">/mês</span>
                        </div>
                    </div>
                    <ul class="plan-features">
                        <li><i class="fas fa-check"></i> Até 2 quadras</li>
                        <li><i class="fas fa-check"></i> 100 reservas/mês</li>
                        <li><i class="fas fa-check"></i> Relatórios básicos</li>
                        <li><i class="fas fa-check"></i> Suporte por email</li>
                    </ul>
                    <a href="https://wa.me/5511987670128?text=Olá! Tenho interesse no plano Bronze da Neo Gestão." 
                       class="plan-btn" target="_blank">
                        <i class="fab fa-whatsapp"></i> Contratar
                    </a>
                </div>

                <!-- Plano Prata -->
                <div class="plan-card silver featured">
                    <div class="plan-badge">Mais Popular</div>
                    <div class="plan-header">
                        <i class="fas fa-trophy"></i>
                        <h3>Prata</h3>
                        <div class="price">
                            <span class="currency">R$</span>
                            <span class="amount">199</span>
                            <span class="period">/mês</span>
                        </div>
                    </div>
                    <ul class="plan-features">
                        <li><i class="fas fa-check"></i> Até 5 quadras</li>
                        <li><i class="fas fa-check"></i> Reservas ilimitadas</li>
                        <li><i class="fas fa-check"></i> Relatórios avançados</li>
                        <li><i class="fas fa-check"></i> App mobile</li>
                        <li><i class="fas fa-check"></i> Suporte prioritário</li>
                    </ul>
                    <a href="https://wa.me/5511987670128?text=Olá! Tenho interesse no plano Prata da Neo Gestão." 
                       class="plan-btn" target="_blank">
                        <i class="fab fa-whatsapp"></i> Contratar
                    </a>
                </div>

                <!-- Plano Ouro -->
                <div class="plan-card gold">
                    <div class="plan-header">
                        <i class="fas fa-crown"></i>
                        <h3>Ouro</h3>
                        <div class="price">
                            <span class="currency">R$</span>
                            <span class="amount">299</span>
                            <span class="period">/mês</span>
                        </div>
                    </div>
                    <ul class="plan-features">
                        <li><i class="fas fa-check"></i> Quadras ilimitadas</li>
                        <li><i class="fas fa-check"></i> Reservas ilimitadas</li>
                        <li><i class="fas fa-check"></i> Relatórios premium</li>
                        <li><i class="fas fa-check"></i> App mobile</li>
                        <li><i class="fas fa-check"></i> Suporte 24/7</li>
                        <li><i class="fas fa-check"></i> Integração personalizada</li>
                    </ul>
                    <a href="https://wa.me/5511987670128?text=Olá! Tenho interesse no plano Ouro da Neo Gestão." 
                       class="plan-btn" target="_blank">
                        <i class="fab fa-whatsapp"></i> Contratar
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <a href="index.php"><img src="./assets/images/financeiro.png" alt="logo"></a>
                    <span>Neo Gestão</span>
                </div>
                <p>&copy; 2025 Neo Gestão. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="./assets/js/index.js"></script>
</body>
</html>