// Espera o DOM carregar antes de executar os scripts
document.addEventListener("DOMContentLoaded", function () {
    console.log("DOM carregado");

    // ----------- Botão de adicionar ambiente -----------
    const addDiv = document.getElementById("addDiv");
    const closeOverlay = document.getElementById("closeOverlay");

    if (addDiv && closeOverlay) {
        addDiv.addEventListener("click", function () {
            const overlay = document.getElementById("overlay");
            if (overlay) overlay.style.display = "flex";
        });

        closeOverlay.addEventListener("click", function () {
            const overlay = document.getElementById("overlay");
            if (overlay) overlay.style.display = "none";
        });
    }

    // ----------- Menu lateral (toggle) -----------
    const menuToggle = document.getElementById("menuToggle");
    const sidebar = document.querySelector(".sidebar");
    const icon = document.getElementById("menuIcon");

    if (menuToggle && sidebar && icon) {
        menuToggle.addEventListener("click", function () {
            sidebar.classList.toggle("collapsed");

            if (sidebar.classList.contains("collapsed")) {
                this.style.left = "0px";
                icon.innerHTML = "&#9654;";
            } else {
                this.style.left = "250px";
                icon.innerHTML = "&#9664;";
            }
        });
    } else {
        console.warn("Elementos do menu lateral não encontrados.");
    }

    // ----------- Botão de fechar overlay de edição -----------
    const closeOverlayEdit = document.getElementById("closeOverlayEdit");
    if (closeOverlayEdit) {
        closeOverlayEdit.addEventListener("click", function () {
            const overlayEdit = document.getElementById("overlayEdit");
            if (overlayEdit) overlayEdit.style.display = "none";
        });
    }
});

// ----------- Função para abrir o overlay de edição -----------
function openEditForm(button) {
    const row = button.parentElement.parentElement;
    const id = row.getAttribute("data-id");
    const nome = row.cells[0].innerText;
    const email = row.cells[1].innerText;

    document.getElementById('nomeEdit').value = nome;
    document.getElementById('emailEdit').value = email;

    const form = document.getElementById("formEdit");
    let hiddenInput = document.getElementById("idEdit");

    if (!hiddenInput) {
        hiddenInput = document.createElement("input");
        hiddenInput.type = "hidden";
        hiddenInput.name = "id";
        hiddenInput.id = "idEdit";
        form.appendChild(hiddenInput);
    }

    hiddenInput.value = id;
    document.getElementById('overlayEdit').style.display = 'flex';
}




document.addEventListener("DOMContentLoaded", function () {
    // ----------------- Professores/Disciplinas -----------------
    const addRowBtn = document.getElementById("addRow");
    const profTableBody = document.getElementById("professoresDisciplinasTable");

    function atualizarBotoesRemover() {
        const rows = document.querySelectorAll(".rowEntry");
        rows.forEach((row) => {
            const btn = row.querySelector(".removeRow");
            if (btn) {
                btn.style.display = rows.length > 1 ? "inline-block" : "none";
            }
        });
    }

    if (addRowBtn && profTableBody) {
        addRowBtn.addEventListener("click", function () {
            const firstRow = profTableBody.querySelector(".rowEntry");

            if (!firstRow) {
                alert("Linha base não encontrada.");
                return;
            }

            const newRow = firstRow.cloneNode(true);

            newRow.querySelector(".professorSelect").value = "";
            const disciplinaSelect = newRow.querySelector(".disciplinaSelect");
            disciplinaSelect.value = "";

            const novaInput = newRow.querySelector(".novaDisciplinaInput");
            novaInput.value = "";
            novaInput.style.display = "none";

            profTableBody.appendChild(newRow);
            atualizarBotoesRemover();
        });

        // Exibe/esconde input de nova disciplina dinamicamente
        document.addEventListener("change", function (e) {
            if (e.target.classList.contains("disciplinaSelect")) {
                const input = e.target.closest("tr").querySelector(".novaDisciplinaInput");
                input.style.display = (e.target.value === "adicionar") ? "inline-block" : "none";
            }
        });

        // Remove linha de professor/disciplina
        document.addEventListener("click", function (e) {
            const removeBtn = e.target.closest(".removeRow");
            if (removeBtn) {
                const row = removeBtn.closest(".rowEntry");
                row.remove();
                atualizarBotoesRemover();
            }
        });

        atualizarBotoesRemover();
    }

    // ----------------- Alunos/Responsáveis -----------------
    const addAlunoBtn = document.getElementById("addAlunoRow");
    const alunoTableBody = document.getElementById("alunosResponsaveisTable");

    function atualizarRemocaoAluno() {
        const rows = document.querySelectorAll(".alunoRow");
        rows.forEach(row => {
            const btn = row.querySelector(".removeRowAluno");
            if (btn) {
                btn.style.display = (rows.length > 1) ? "inline-block" : "none";
            }
        });
    }

    if (addAlunoBtn && alunoTableBody) {
        addAlunoBtn.addEventListener("click", function () {
            const firstRow = alunoTableBody.querySelector(".alunoRow");
            if (!firstRow) return;

            const newRow = firstRow.cloneNode(true);
            const inputs = newRow.querySelectorAll("input");
            inputs.forEach(input => input.value = "");

            alunoTableBody.appendChild(newRow);
            atualizarRemocaoAluno();
        });

        document.addEventListener("click", function (e) {
            const botao = e.target.closest(".removeRowAluno");
            if (botao) {
                const row = botao.closest(".alunoRow");
                row.remove();
                atualizarRemocaoAluno();
            }
        });

        atualizarRemocaoAluno();
    }
});




    // ----------------- Exclusão de Professor/Disciplina -----------------
    let idParaExcluir = null;

    function confirmarExclusao(id) {
        idParaExcluir = id;
        document.getElementById("overlay").style.display = "flex";
    }

    function fecharOverlay() {
        document.getElementById("overlay").style.display = "none";
        idParaExcluir = null;
    }

    function excluirConfirmado() {
        fetch(`../php/excluirProfessorDisciplina.php?id=${idParaExcluir}`, {
            method: "GET"
        }).then(res => res.text()).then(response => {
            if (response.trim() === "ok") {
                const row = document.querySelector(`tr[data-id='${idParaExcluir}']`);
                if (row) row.remove();
            } else {
                alert("Erro ao excluir.");
            }
            fecharOverlay();
        });
    }


document.addEventListener("DOMContentLoaded", function () {
    // ----------------- Toggle Responsáveis do Aluno -----------------
    document.querySelectorAll(".btn-toggle").forEach(button => {
        button.addEventListener("click", function () {
            const alunoId = this.getAttribute("data-id");
            const linhaResp = document.getElementById(`resp-${alunoId}`);
            const container = document.getElementById(`container-${alunoId}`);

            if (linhaResp.style.display === "none") {
                linhaResp.style.display = "table-row";

                if (!container.dataset.loaded) {
                    fetch(`../php/carregarResponsaveisLista.php?id_aluno=${alunoId}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.length > 0) {
                                let html = `<table class="tabela-responsaveis" style="width: 100%;">
                                                <thead><tr><th colspan='2'>Responsáveis</th></tr></thead>
                                                <tbody>`;
                                data.forEach(item => {
                                    html += `<tr><td>${item.nome}</td><td>${item.email}</td></tr>`;
                                });
                                html += `</tbody></table>`;
                                container.innerHTML = html;
                            } else {
                                container.innerHTML = "<p><em>Erro! Nenhum responsável registrado.</em></p>";
                            }
                            container.dataset.loaded = "true";
                        });
                }
            } else {
                linhaResp.style.display = "none";
            }
        });
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const btnTurmas = document.getElementById("btnTurmas");
    const btnProfessores = document.getElementById("btnProfessores");

    const sectionTurmas = document.getElementById("sectionTurmas");
    const sectionProfessores = document.getElementById("sectionProfessores");

    if (btnTurmas && btnProfessores && sectionTurmas && sectionProfessores) {
        btnTurmas.addEventListener("click", function () {
            sectionTurmas.style.display = "block";
            sectionProfessores.style.display = "none";
        });

        btnProfessores.addEventListener("click", function () {
            sectionTurmas.style.display = "none";
            sectionProfessores.style.display = "block";
        });
    }
});



function mostrarSecao(secao) {
    document.querySelectorAll('.recado-section').forEach(s => s.classList.remove('active'));
    document.getElementById('secao-' + secao).classList.add('active');

    document.querySelectorAll('.recado-menu button').forEach(b => b.classList.remove('active'));
    document.querySelector('.recado-menu button[onclick="mostrarSecao(\'' + secao + '\')"]').classList.add('active');
}

