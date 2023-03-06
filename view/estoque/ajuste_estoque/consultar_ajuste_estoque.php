<div class="title">
    <label class="form-label">Consultar produtos</label>
</div>

<hr>

<div class="row">
    <div class="col-md  mb-2">
        <div class="input-group">
            <input type="text" class="form-control" id="pesquisa_conteudo" placeholder="Tente pesquisar pela descrição, referência, fabricante ou código"
                aria-label="Recipient's username" aria-describedby="button-addon2">
            <button class="btn btn-outline-secondary" type="button" id="pesquisar_filtro_pesquisa">Pesquisar</button>
        </div>
    </div>
    <div class="col-md-auto  d-grid gap-2 d-sm-block mb-1">
        <button class="btn btn-outline-secondary" type="button" id="adicionar_produto">Historico ajuste</button>
    </div>
</div>

<div class="alerta"></div>
<div class="tabela"></div>


<script src="js/estoque/ajuste_estoque/consultar_ajuste_estoque.js"></script>