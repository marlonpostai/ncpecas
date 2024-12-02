<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Landing Page - Sistema de Orçamentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .hero {
            background: linear-gradient(to right, #007bff, #0056b3);
            color: white;
            padding: 60px 20px;
            text-align: center;
        }

        .features {
            padding: 60px 20px;
            background-color: #f9f9f9;
        }

        .cta {
            background: #0056b3;
            color: white;
            padding: 40px 20px;
            text-align: center;
        }

        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1 class="display-4">Bem-vindo ao Sistema de Orçamentos maneiro funcionando</h1>
            <p class="lead">Automatize seus processos de orçamento e aumente a eficiência do seu negócio.</p>
            <div class="mt-4">
                <a href="#features" class="btn btn-light btn-lg me-3">Saiba Mais</a>
                <!-- Botão para acessar o sistema -->
                <a href="/admin" class="btn btn-outline-light btn-lg">Acessar o Sistema</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features">
        <div class="container">
            <h2 class="text-center">Por que usar nosso sistema?</h2>
            <div class="row mt-4">
                <div class="col-md-4 text-center">
                    <img src="https://via.placeholder.com/100" alt="Feature 1" class="mb-3">
                    <h4>Agilidade</h4>
                    <p>Crie orçamentos de forma rápida e eficiente com apenas alguns cliques.</p>
                </div>
                <div class="col-md-4 text-center">
                    <img src="https://via.placeholder.com/100" alt="Feature 2" class="mb-3">
                    <h4>Personalização</h4>
                    <p>Adapte o sistema às necessidades do seu negócio e ganhe flexibilidade.</p>
                </div>
                <div class="col-md-4 text-center">
                    <img src="https://via.placeholder.com/100" alt="Feature 3" class="mb-3">
                    <h4>Integração</h4>
                    <p>Integre com outros sistemas e otimize sua gestão empresarial.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="cta">
        <div class="container">
            <h2>Pronto para começar?</h2>
            <p class="lead">Entre em contato conosco e veja como podemos ajudar o seu negócio a crescer.</p>
            <a href="mailto:contato@seusite.com" class="btn btn-light btn-lg">Entre em Contato</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Sistema de Orçamentos. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
