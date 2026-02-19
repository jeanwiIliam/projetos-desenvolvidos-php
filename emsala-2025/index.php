<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/homepage/styles.css">
    
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>EmSala</title>
</head>
<body>
    <header>
        <nav id="navbar">
            <i class="fa-solid fa-chalkboard-user"id="nav_logo"> Em Sala</i>
        

            <a href="login.php">
                <button class="btn-default">
                    Login
                </button>
            </a>

            <button id="mobile_btn">
                <i class="fa-solid fa-bars"></i>
            </button>
        </nav>

        <div id="mobile_menu">
            <ul id="mobile_nav_list">
                <li class="nav-item">
                    <a href="#home ">inicio</a>
                </li>

            </ul>

            <a href="login.php">
                <button class="btn-default">
                    Login
                </button>
            </a>
        </div>
    </header>

    <main id="content">
        <section id="home">
            <div class="shape"><img src="img/main.png" alt=""></div>
            <div id="cta">
                <h1 class="title">
                    Quem Somos
                    <span>?</span>
                </h1>

                <p class="description">O Em Sala é um sistema desenvolvido para aproximar escolas, responsáveis e alunos por meio de uma comunicação eficiente e centralizada. A plataforma permite o envio de mensagens, avisos e informações importantes, além de possibilitar o acompanhamento da rotina escolar, promovendo uma participação mais ativa dos responsáveis na vida acadêmica dos alunos.</p>

        
            </div>


        </section>

        <section id="menu">

            <div id="dishes">
                <div class="dish">
                    <img src="img/admin.png" alt="">
                    <h3 class="dish-title">Administrador</h3>

                    <span class="dish-description">
                        O administrador é responsável pela gestão completa do sistema. É  o único usuário que se cadastra por conta própria e, uma vez logado, ele pode cadastrar ambientes (escolas), criar turmas e vincular professores, alunos e responsáveis. É quem organiza e estrutura a plataforma para o bom funcionamento da comunicação entre todos os usuários.
                    </span>
                   
                </div>

                <div class="dish">
                    

                    <img src="img/teacher_2307607.png" alt="">
                    <h3 class="dish-title">Professor</h3>

                    <span class="dish-description">
                        O professor tem acesso às turmas em que está vinculado, podendo visualizar suas disciplinas e enviar recados gerais (para toda a turma) ou individuais (diretamente para um aluno). Também pode se comunicar diretamente com os responsáveis dos seus alunos, promovendo um contato mais próximo com as famílias.
                    </span>

                </div>

                <div class="dish">
                    

                    <!--coolocar imagens dos materias -->
                    <img src="img/responsavel.png" alt="">
                    <h3 class="dish-title">Responsável</h3>

                    <span class="dish-description">
                        O responsável pode visualizar todos os alunos sob sua responsabilidade, acessar suas disciplinas e ler os recados enviados pelos professores. Além disso, pode conversar diretamente com os professores responsáveis pelas turmas, facilitando o acompanhamento escolar dos filhos.
                    </span>

                </div>

                <div class="dish">
                   

                    <!--coolocar imagens dos materias -->
                    <img src="img/aluno.png" alt="">
                    <h3 class="dish-title">Aluno</h3>

                    <span class="dish-description">
                        O aluno pode visualizar suas disciplinas, acompanhar os recados enviados pelo professor e ficar por dentro de todas as atualizações relacionadas à sua turma. A plataforma é simples e permite ao estudante acessar rapidamente as informações importantes do seu dia a dia escolar.
                    </span>

                </div>
            </div>


        </section>
    </main>
    
    <footer>
        <img src="img/wave.svg" alt="">
        <div id="footer_items">
            <span id="copyright">
                &copy 2025 Em Sala
            </span>
        </div>
    </footer>

    <script src="js/script2.js"></script>
</body>
</html>