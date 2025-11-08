<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Texto para Braille 3D - ETEC Ilha Solteira</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/css/viewer.css"/>
    
    <script type="text/javascript" src="lightgl.js"></script>
    <script type="text/javascript" src="csg.js"></script>
    <script type="text/javascript" src="openjscad.js"></script>
    <script type="text/javascript" src="braille.jscad" charset="utf-8"></script>
    <script type="text/javascript" src="jquery-1.10.1.min.js"></script>
    <script src="filtros.js"></script>
    <script>
        var gProcessor = null;
        var detailsOffset = 4;
        var detailsAmount = 7;

        // Show all exceptions to the user:
        OpenJsCad.AlertUserOfUncaughtExceptions();

        function onload() {
            gProcessor = new OpenJsCad.Processor(document.getElementById("viewer"));
            jQuery.get('braille.jscad', function (data) {
                gProcessor.setJsCad(data, "braille.jscad");
                showDetails(false);
            });

            adaptControls();
        }

        function adaptControls() {
            if (gProcessor.viewer != null)
                gProcessor.viewer.gl.clearColor(1, 1, 0.97, 1);

            $("#viewer .viewer")[0].style.backgroundColor = "white";
            
            $("#viewer .parametersdiv button")[0].onclick = parseParameters;

            var moreElement = "<hr/><p><a id='more'></a></p>";

            $("#viewer .parametersdiv .parameterstable").after(moreElement);

            setLanguage("portuguese");
        }

        function setLanguage(lang) {
            if (lang == "portuguese") {
                $("#viewer .parametersdiv button")[0].innerHTML = "Gerar Modelo 3D";
            }
        }

        function showDetails(show) {
            var tableRows = $("#viewer .parametersdiv .parameterstable tr");

            for (var i = detailsOffset; i < tableRows.length && i < detailsOffset + detailsAmount; i++) {
                tableRows[i].style.display = (show) ? "table-row" : "none";
            }

            var moreLink = $("#more")[0];
            moreLink.innerHTML = (show) ? "Menos Detalhes" : "Mais Detalhes";
            moreLink.href = "javascript:showDetails(" + !show + ");";
        }

        function parseParameters() {
            var param_form_size = $("#viewer .parametersdiv .parameterstable tr:eq(4) td:eq(1) input")[0];
            param_form_size.value = Math.min(Math.max(param_form_size.value, 0.0), 10.0);

            var param_dot_height = $("#viewer .parametersdiv .parameterstable tr:eq(5) td:eq(1) input")[0];
            param_dot_height.value = Math.min(Math.max(param_dot_height.value, 0.5), 0.8);

            var param_dot_diameter = $("#viewer .parametersdiv .parameterstable tr:eq(6) td:eq(1) input")[0];
            param_dot_diameter.value = Math.min(Math.max(param_dot_diameter.value, 1.4), 1.6);

            var param_plate_thickness = $("#viewer .parametersdiv .parameterstable tr:eq(7) td:eq(1) input")[0];
            param_plate_thickness.value = Math.max(param_plate_thickness.value, 0.0);

            var param_resolution = $("#viewer .parametersdiv .parameterstable tr:eq(10) td:eq(1) input")[0];
            var isnumber = !isNaN(parseInt(param_resolution.value)) && isFinite(param_resolution.value);
            var resolution = (isnumber) ? parseInt(param_resolution.value) : 0;
            resolution = Math.min(Math.max(param_resolution.value, 10), 30);
            resolution += (resolution % 2);
            param_resolution.value = resolution;

            gProcessor.rebuildSolid();
        }

        window.onload = function () {
            const savedFilter = localStorage.getItem("colorblind-filter") || "default";
            
            applyColorblindFilter(savedFilter);
            const filterSelect = document.getElementById("colorblind-filter");
            if (filterSelect) {
                filterSelect.value = savedFilter;
            }

            // Inicialização do OpenJSCAD
            gProcessor = new OpenJsCad.Processor(document.getElementById("viewer"));
            jQuery.get('braille.jscad', function (data) {
                gProcessor.setJsCad(data, "braille.jscad");
                showDetails(false);
            });

            adaptControls();

            setTimeout(() => {
                document.querySelector('#viewer .statusdiv select option[value="x3d"]').disabled = true;
            }, 4000);

            
            const parametersDiv = document.querySelector('.parametersdiv')
            
            const viewerID = document.getElementById('viewer');
            const viewerClass = document.querySelector('.viewer');
            const scrollBar = document.querySelector('div[style*="overflow-x: scroll"]')
            const statusDiv = document.querySelector('.statusdiv')
            const canvasContent = document.createElement('div');
            canvasContent.classList.add('canvas-content');
            
            
            canvasContent.appendChild(viewerClass);
            canvasContent.appendChild(scrollBar);
            canvasContent.appendChild(statusDiv);
            
            viewerID.prepend(canvasContent)
            
            
            <?php if(isset($_SESSION['logado']) && $_SESSION['logado'] === TRUE) {?>
                const salvarPlacaBtn = document.createElement('button');
                salvarPlacaBtn.classList.add('salvar-placa-btn');
                salvarPlacaBtn.innerHTML = 'Salvar';
                
                parametersDiv.appendChild(salvarPlacaBtn);

                
                <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] === TRUE && isset($placa)) { ?>
                    setTimeout(() => {
                        const paramsDiv = document.querySelector('.parametersdiv');
                        if (!paramsDiv) {
                            console.warn("⚠️ Parâmetros ainda não carregados.");
                            return;
                        }

                        // Agora é seguro preencher os campos
                        const textarea = paramsDiv.querySelector('textarea');
                        if (textarea) textarea.value = <?php echo json_encode($placa['texto']); ?>;

                        const checkboxes = paramsDiv.querySelectorAll('input[type="checkbox"]');
                        if (checkboxes.length >= 5) {
                            checkboxes[0].checked = <?php echo (int)$placa['uppercase']; ?>;
                            checkboxes[1].checked = <?php echo (int)$placa['contracoes']; ?>;
                            checkboxes[3].checked = <?php echo (int)$placa['canto_referencia']; ?>;
                            checkboxes[4].checked = <?php echo (int)$placa['suporte']; ?>;
                        }

                        const inputs = paramsDiv.querySelectorAll('input[type="text"]');
                        if (inputs.length >= 5) {
                            inputs[0].value = <?php echo json_encode($placa['tam_forma']); ?>;
                            inputs[1].value = <?php echo json_encode($placa['altura_ponto']); ?>;
                            inputs[2].value = <?php echo json_encode($placa['diametro_ponto']); ?>;
                            inputs[3].value = <?php echo json_encode($placa['espessura']); ?>;
                            inputs[4].value = <?php echo json_encode($placa['margem']); ?>;
                        }

                        console.log("✅ Dados da placa carregados do PHP.");
                    }, 2000); // espera 2 segundos o OpenJsCad montar os campos
                    <?php } ?>


                salvarPlacaBtn.addEventListener('click', (event) => {
                    event.preventDefault();

                    const texto = document.querySelector('.parametersdiv textarea').value || '';
                    const uppercase = document.querySelectorAll('.parametersdiv input[type="checkbox"]')[0].checked ? '1' : '0';
                    const contracoes = document.querySelectorAll('.parametersdiv input[type="checkbox"]')[1].checked ? '1' : '0';
                    const tam_forma = document.querySelectorAll('.parametersdiv input[type="text"]')[0].value || '';
                    const altura_ponto = document.querySelectorAll('.parametersdiv input[type="text"]')[1].value || '';
                    const diametro_ponto = document.querySelectorAll('.parametersdiv input[type="text"]')[2].value || '';
                    const espessura = document.querySelectorAll('.parametersdiv input[type="text"]')[3].value || '';
                    const margem = document.querySelectorAll('.parametersdiv input[type="text"]')[4].value || '';
                    const canto_referencia = document.querySelectorAll('.parametersdiv input[type="checkbox"]')[3].checked ? '1' : '0';
                    const suporte = document.querySelectorAll('.parametersdiv input[type="checkbox"]')[4].checked ? '1' : '0';
    0
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/';
                    form.style.display = 'none';

                    function addInput(name, value) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = name;
                        input.value = value;
                        form.appendChild(input);
                    }

                    addInput("texto", texto);
                    addInput("uppercase", uppercase);
                    addInput("contracoes", contracoes);
                    addInput("tam_forma", tam_forma);
                    addInput("altura_ponto", altura_ponto);
                    addInput("diametro_ponto", diametro_ponto);
                    addInput("espessura", espessura);
                    addInput("margem", margem);
                    addInput("canto_referencia", canto_referencia);
                    addInput("suporte", suporte);

                    document.body.appendChild(form);
                    form.submit();
                });
            <?php }?>
        };
    </script>
</head>
<body onload="onload()">

    <div id="main-content-wrapper">
        <?php include VIEWS . "includes/alert.php";?>
        <?php include VIEWS . 'includes/navbar.php';?>
        <h1 style="text-align: center; margin: 20px; margin-top: 30px;">Converta seu texto para Braille 3D</h1>
        <div class="container-viewer">
            <div id="viewer"></div>
        </div>
        <?php include VIEWS . "includes/footer.php";?>
    </div>

    <?php include VIEWS . 'includes/filtros-cor.php';?>
</body>
</html>