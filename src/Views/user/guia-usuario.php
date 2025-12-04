<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <script src="https://kit.fontawesome.com/412e60f1e0.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css"> 
    <link rel="stylesheet" href="assets/css/guia.css"> 
    <title>Braille3D - Guia de Ajuda</title>
</head>
<body>
    <?php include VIEWS . "includes/alert.php";?>

    <style>

        ul {
            list-style: none;
        }

        /* Estilos base para a página Guia */
        #guia-container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 20px;
            background: var(--bg-dark); /* Fundo escuro para a área principal do conteúdo */
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            /* Novo: Garantir padding em telas pequenas */
            min-height: 80vh; 
        }

        .section-title {
            margin-top: 30px;
            color: var(--accent-blue);
            font-family: var(--font-chamativa);
            margin-bottom: 30px;
            border-bottom: 2px solid var(--light-blue);
            padding-bottom: 10px;
            font-size: 1.8rem; /* Ajuste para telas grandes */
        }
        
        /* Estilos do Sumário */
        #sumario {
            background: var(--bg-accent-light);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        #sumario h3 {
            color: var(--vibrant-blue);
            margin-bottom: 15px;
            font-family: var(--font-chamativa);
            font-size: 1.2rem;
        }

        #sumario a {
            color: var(--text-light);
            text-decoration: none;
            display: block;
            padding: 5px 0;
            transition: color 0.3s;
        }

        #sumario a:hover {
            color: var(--light-blue);
        }

        /* Estilos do Acordeão */
        .acordeao-item {
            background: var(--bg-accent-light);
            border-radius: 8px;
            margin-bottom: 15px;
            overflow: hidden;
            border: 1px solid var(--medium-dark-gray);
        }

        .acordeao-cabecalho {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            cursor: pointer;
            background: var(--bg-secondary);
            color: var(--text-light);
            font-weight: 600;
            font-family: var(--font-chamativa);
            transition: background 0.3s;
        }

        .acordeao-cabecalho:hover {
            background: var(--dark-blue);
        }

        .acordeao-icone {
            transition: transform 0.3s;
        }

        .acordeao-conteudo {
            padding: 0 20px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out, padding 0.3s ease-out;
            background: var(--bg-accent-light);
        }
        
        /* Adiciona transição suave e padding ao abrir */
        .acordeao-item.ativo .acordeao-conteudo {
            max-height: 1000px; /* Aumentado para garantir espaço para fotos */
            padding: 20px;
        }

        .acordeao-item.ativo .acordeao-icone {
            transform: rotate(180deg);
        }

        /* Área de Fotos - FLEXBOX para ajuste de layout */
        .param-fotos {
            display: flex;
            gap: 15px;
            margin: 20px 0;
            justify-content: space-around;
        }

        .foto-placeholder {
            flex: 1;
            min-height: 150px;
            background: var(--medium-dark-gray);
            border: 2px dashed var(--medium-gray);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            text-align: center;
            font-style: italic;
        }

        /* ======================================================= */
        /* MEDIAS QUERIES (RESPONSIVIDADE) */
        /* ======================================================= */

        /* Telas Menores que 768px (Tablets e Celulares) */
        @media (max-width: 768px) {
            #guia-container {
                margin: 20px 10px; /* Reduz margens laterais */
                padding: 15px;
            }

            .section-title {
                font-size: 1.5rem; /* Títulos menores */
                margin-bottom: 20px;
            }

            .acordeao-cabecalho {
                padding: 12px 15px;
                font-size: 0.95rem; /* Texto do cabeçalho levemente menor */
            }

            .acordeao-conteudo p, .acordeao-conteudo li {
                font-size: 0.9rem; /* Texto de conteúdo menor */
            }

            /* Stack das fotos em telas menores */
            .param-fotos {
                flex-direction: column;
                gap: 10px;
            }

            .foto-placeholder {
                min-height: 100px; /* Altura reduzida para placeholders */
                font-size: 0.8rem;
            }
        }

        /* Telas Extremamente Pequenas (Celulares) */
        @media (max-width: 480px) {
            #guia-container {
                margin: 15px 5px; 
                padding: 10px;
            }
            .acordeao-cabecalho {
                padding: 10px;
            }
            .acordeao-conteudo {
                padding: 15px;
            }
            .acordeao-item.ativo .acordeao-conteudo {
                padding: 15px;
            }
        }
    </style>
    <div id="main-content-wrapper">
        <?php include VIEWS . "includes/navbar.php";?>
        <div id="guia-container">
            <h1 class="section-title"><i class="fas fa-question-circle"></i> Guia de Ajuda Braille3D</h1>
            
            <section id="sumario">
                <h3>Sumário de Conteúdo</h3>
                <nav>
                    <a href="#placas-braille"><i class="fas fa-print"></i> Parâmetros de Criação de Placas Braille</a>
                    <a href="#gestao-conta"><i class="fas fa-user-cog"></i> Gestão e Configurações da Conta</a>
                </nav>
            </section>
            
            <hr>

            <section id="placas-braille">
                <h2 class="section-title">🛠️ Parâmetros de Criação de Placas Braille</h2>
                <p style='padding-bottom: 10px;'>Aqui você encontra a explicação detalhada de cada campo para garantir que suas placas 3D atendam aos padrões ABNT e suas necessidades de impressão.</p>

                <div class="acordeao-item">
                    <div class="acordeao-cabecalho" data-target="texto-conteudo">
                        <span>1. Texto</span>
                        <i class="fas fa-chevron-down acordeao-icone"></i>
                    </div>
                    <div class="acordeao-conteudo" id="texto-conteudo">
                        <p>Define o texto que será convertido para Braille e impresso na placa. O sistema realiza a conversão automática, mas o comprimento do texto afeta o tamanho final da placa.</p>
                        <ul>
                            <li><strong>Entrada</strong>: Texto simples (ex: "Olá Mundo").</li>
                            <li><strong>Importante</strong>: A norma ABNT NBR 9050 exige que o texto também esteja impresso em caracteres comuns (relevo) na placa para auxiliar quem não está familiarizado com Braille.</li>
                        </ul>
                        <div class="param-fotos">
                            <div class="foto-placeholder">Foto Exemplo: Placa com 'Olá Mundo'</div>
                            <div class="foto-placeholder">Foto Exemplo: Placa com texto longo</div>
                        </div>
                    </div>
                </div>

                <div class="acordeao-item">
                    <div class="acordeao-cabecalho" data-target="opcoes-conteudo">
                        <span>2. Opções de Conversão (Caixas de Seleção)</span>
                        <i class="fas fa-chevron-down acordeao-icone"></i>
                    </div>
                    <div class="acordeao-conteudo" id="opcoes-conteudo">
                        <p>Estas opções ajustam a conversão do texto para o Braille:</p>
                        
                        <p><strong>Permitir letras maiúsculas:</strong></p>
                        <ul>
                            <li><strong>Marcado</strong>: Inclui o sinal de letra maiúscula (ponto 6) no Braille, seguindo as regras de transcrição.</li>
                            <li><strong>Desmarcado</strong>: O texto é transcrito em minúsculas (ignora o ponto 6), simplificando o relevo.</li>
                        </ul>
                        
                        <p><strong>Contrações:</strong></p>
                        <ul>
                            <li><strong>Marcado</strong>: O texto é transcrito usando o **Braille de grau 2** (com contrações/abreviaturas), tornando-o mais conciso.</li>
                            <li><strong>Desmarcado</strong>: O texto é transcrito usando o **Braille de grau 1** (letra por letra), mais fácil de ler para iniciantes.</li>
                        </ul>

                        <p><strong>Conversão direta:</strong></p>
                        <ul>
                            <li>Opção para aplicar uma conversão simples, ignorando regras complexas de pontuação e formatação, útil para textos técnicos ou não padronizados.</li>
                        </ul>
                        <div class="param-fotos">
                            <div class="foto-placeholder">Foto Exemplo: Braille Grau 1 (Sem Contração)</div>
                            <div class="foto-placeholder">Foto Exemplo: Braille Grau 2 (Com Contração)</div>
                        </div>
                    </div>
                </div>

                <div class="acordeao-item">
                    <div class="acordeao-cabecalho" data-target="tamanho-forma-conteudo">
                        <span>3. Tamanho da Forma [0 – 10]</span>
                        <i class="fas fa-chevron-down acordeao-icone"></i>
                    </div>
                    <div class="acordeao-conteudo" id="tamanho-forma-conteudo">
                        <p>Controla o espaçamento geral entre os pontos Braille e entre as células, afetando a legibilidade e o tamanho total da placa.</p>
                        <ul>
                            <li><strong>Valor 5 (Padrão)</strong>: Geralmente segue as normas internacionais de espaçamento (ABNT).</li>
                            <li><strong>Valores Maiores (>5)</strong>: Aumentam o espaçamento, tornando a placa maior e potencialmente mais fácil de distinguir para alguns usuários.</li>
                            <li><strong>Valores Menores</strong> (<5): Diminuem o espaçamento, compactando a placa.</li>
                        </ul>
                        <div class="param-fotos">
                            <div class="foto-placeholder">Foto Exemplo: Tamanho da Forma = 2 (Compacto)</div>
                            <div class="foto-placeholder">Foto Exemplo: Tamanho da Forma = 8 (Espaçado)</div>
                        </div>
                    </div>
                </div>

                <div class="acordeao-item">
                    <div class="acordeao-cabecalho" data-target="ponto-conteudo">
                        <span>4. Altura e Diâmetro do Ponto</span>
                        <i class="fas fa-chevron-down acordeao-icone"></i>
                    </div>
                    <div class="acordeao-conteudo" id="ponto-conteudo">
                        <p>Ajustam as dimensões físicas dos pontos individuais, essenciais para a percepção tátil e a conformidade com as normas.</p>

                        <p><strong>Altura do ponto [0,5 – 0,8] (mm):</strong></p>
                        <ul>
                            <li>Define o quão alto o ponto se eleva da superfície da placa. A norma ABNT NBR 9050 sugere uma altura em torno de <strong>0,7 mm</strong>.</li>
                        </ul>

                        <p><strong>Diâmetro da ponta [1,4 – 1,6] (mm):</strong></p>
                        <ul>
                            <li>Define a largura da base do ponto. A norma ABNT NBR 9050 sugere um diâmetro da base em torno de <strong>1,4 mm</strong>.</li>
                        </ul>
                        <div class="param-fotos">
                            <div class="foto-placeholder">Foto Exemplo: Altura = 0.5 (Baixo)</div>
                            <div class="foto-placeholder">Foto Exemplo: Altura = 0.8 (Alto)</div>
                        </div>
                    </div>
                </div>

                <div class="acordeao-item">
                    <div class="acordeao-cabecalho" data-target="placa-conteudo">
                        <span>5. Espessura e Margem da Placa (mm)</span>
                        <i class="fas fa-chevron-down acordeao-icone"></i>
                    </div>
                    <div class="acordeao-conteudo" id="placa-conteudo">
                        <p>Controlam o corpo estrutural da placa e o espaço ao redor do texto Braille.</p>

                        <p><strong>Espessura da placa (mm):</strong></p>
                        <ul>
                            <li>Define a espessura total do corpo da placa (excluindo a altura do ponto). Uma espessura maior confere maior robustez (ex: **2 mm**).</li>
                        </ul>

                        <p><strong>Margem da placa (mm):</strong></p>
                        <ul>
                            <li>Define a distância mínima entre o texto Braille e as bordas da placa. Margens maiores melhoram a estética e facilitam a fixação.</li>
                        </ul>
                        <div class="param-fotos">
                            <div class="foto-placeholder">Foto Exemplo: Margem = 2 (Aperta)</div>
                            <div class="foto-placeholder">Foto Exemplo: Margem = 10 (Larga)</div>
                        </div>
                    </div>
                </div>
                
                <div class="acordeao-item">
                    <div class="acordeao-cabecalho" data-target="extras-conteudo">
                        <span>6. Geração de Extras</span>
                        <i class="fas fa-chevron-down acordeao-icone"></i>
                    </div>
                    <div class="acordeao-conteudo" id="extras-conteudo">
                        <p>Opções de auxílio à impressão 3D e instalação:</p>

                        <p><strong>Gerar canto de referência:</strong></p>
                        <ul>
                            <li><strong>Marcado</strong>: Adiciona um pequeno ponto ou marca no canto superior esquerdo da placa, facilitando a orientação do usuário (ou para referência de máquina).</li>
                        </ul>
                        <br>
                        <p><strong>Gerar suportes para impressão?</strong></p>
                        <ul>
                            <li><strong>Marcado</strong>: Adiciona estruturas de suporte ao modelo STL, auxiliando a impressão 3D (especialmente para letras em relevo ou placas com formato complexo).</li>
                            <li><strong>Desmarcado</strong>: O arquivo STL é gerado sem suportes; a adição deve ser configurada no seu software de fatiamento 3D (slicer).</li>
                        </ul>
                        <div class="param-fotos">
                            <div class="foto-placeholder">Foto Exemplo: Placa com Canto de Referência</div>
                            <div class="foto-placeholder">Foto Exemplo: Placa com Suportes 3D</div>
                        </div>
                    </div>
                </div>
            </section>

            <hr>

            <section id="gestao-conta">
                <h2 class="section-title">⚙️ Gestão e Configurações da Conta</h2>
                <p style='padding-bottom: 10px;'>Aqui você aprende a gerenciar suas informações pessoais e de segurança na plataforma Braille3D.</p>
                
                <div class="acordeao-item">
                    <div class="acordeao-cabecalho" data-target="dados-conteudo">
                        <span>7. Edição de Nome e E-mail</span>
                        <i class="fas fa-chevron-down acordeao-icone"></i>
                    </div>
                    <div class="acordeao-conteudo" id="dados-conteudo">
                        <p>Acesse o menu "Minha Conta" para atualizar seus dados.</p>
                        <p><strong>Alterar Nome:</strong></p>
                        <ul>
                            <li>Insira o novo nome e confirme a alteração. O nome é usado para personalização e comunicação.</li>
                        </ul>
                        <p><strong>Alterar E-mail:</strong></p>
                        <ul>
                            <li>Insira o novo endereço de e-mail.</li>
                            <li>Um <strong>E-mail de Verificação</strong> será enviado para o novo endereço. Você deve clicar no link contido neste e-mail para validar a mudança e começar a usá-lo para login e notificações.</li>
                        </ul>
                    </div>
                </div>

                <div class="acordeao-item">
                    <div class="acordeao-cabecalho" data-target="senha-conteudo">
                        <span>8. Troca de Senha</span>
                        <i class="fas fa-chevron-down acordeao-icone"></i>
                    </div>
                    <div class="acordeao-conteudo" id="senha-conteudo">
                        <p>Para sua segurança, siga os passos no menu "Segurança da Conta":</p>
                        <ol>
                            <li>Informe sua **Senha Atual** (para verificar sua identidade).</li>
                            <li>Informe a **Nova Senha**.</li>
                            <li>Confirme a **Nova Senha**.</li>
                        </ol>
                        <p>É recomendável usar uma senha forte, combinando letras maiúsculas, minúsculas, números e símbolos.</p>
                    </div>
                </div>

                <div class="acordeao-item">
                    <div class="acordeao-cabecalho" data-target="exclusao-conteudo">
                        <span>9. Exclusão da Conta</span>
                        <i class="fas fa-chevron-down acordeao-icone"></i>
                    </div>
                    <div class="acordeao-conteudo" id="exclusao-conteudo">
                        <p>Se você deseja desativar permanentemente sua conta:</p>
                        <ul>
                            <li>Vá para "Minha Conta" > "Excluir Conta".</li>
                            <li>Será solicitada uma confirmação final, pois esta ação é **irreversível** e apagará todo o seu histórico e modelos salvos.</li>
                        </ul>
                    </div>
                </div>

            </section>

        </div>
        
        <?php include VIEWS . "includes/footer.php";?>
    </div>

    <?php include VIEWS . 'includes/filtros-cor.php';?>
    <script src="filtros.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cabecalhos = document.querySelectorAll('.acordeao-cabecalho');

            cabecalhos.forEach(cabecalho => {
                cabecalho.addEventListener('click', () => {
                    const item = cabecalho.closest('.acordeao-item');
                    const conteudo = document.getElementById(cabecalho.getAttribute('data-target'));

                    // Fecha outros abertos (opcional, mas bom para usabilidade)
                    document.querySelectorAll('.acordeao-item.ativo').forEach(ativoItem => {
                        if (ativoItem !== item) {
                            ativoItem.classList.remove('ativo');
                        }
                    });

                    // Alterna o estado do item clicado
                    item.classList.toggle('ativo');
                });
            });
        });

        // Script para rolagem suave do sumário
        document.querySelectorAll('#sumario a').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                // Ajuste para rolagem suave
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth',
                    block: 'start' // Garante que o topo da seção fique visível
                });
            });
        });
    </script>
</body>
</html>