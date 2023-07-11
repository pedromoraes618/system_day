<div class="title">
    <label class="form-label">Consultar Produtos</label>
</div>
<hr>
<div class="row">
    <div class="col-md-2 mb-2">
        <select name="status" class="form-select" id="status">
            <option value="0">Status..</option>
            <option value="SIM">Ativo</option>
            <option value="NAO">Inativo</option>
        </select>
    </div>
    <div class="col-md  mb-2">
        <div class="input-group">
            <input type="text" class="form-control" id="pesquisa_conteudo" placeholder="Tente pesquisar pela descrição, referência, fabricante, código ou código de barras" aria-label="Recipient's username" aria-describedby="button-addon2">
            <button class="btn btn-outline-secondary" type="button" id="pesquisar_filtro_pesquisa">Pesquisar</button>
        </div>
        <div class="alerta">

        </div>
    </div>
    <div class="col-md-auto  d-grid gap-2 d-sm-block mb-1">
        <button class="btn btn-dark" type="button" id="adicionar_produto">Adicionar produto</button>
    </div>
</div>

<div class="tabela">

</div>
<div class="modal_show">

</div>
<script src="js/estoque/produto/consultar_produto.js"></script>